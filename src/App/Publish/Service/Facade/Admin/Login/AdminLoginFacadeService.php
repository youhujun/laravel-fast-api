<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 11:09:29
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 22:40:50
 * @FilePath: \app\Service\Facade\Admin\Login\AdminLoginFacadeService.php
 */

namespace App\Service\Facade\Admin\Login;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\Login\AdminLoginEvent;
use App\Events\Admin\Login\AdminLogoutEvent;

use App\Jobs\Admin\Login\AdminLogoutJob;

use App\Models\Admin\Admin;

use App\Models\Picture\AlbumPicture;


/**
 * @see \App\Facade\Admin\Login\AdminLoginFacade
 */
class AdminLoginFacadeService
{
   public function test()
   {
       echo "AdminLoginFacadeService test";
   }

   /**
     * 后台管理员认证登录 账户|邮箱|手机 登录
     *
     * @param array $validated 验证通过传递过来的参数
     * @return array 返回值
     */
    public function authLogin($validated = [])
    {
        $result = code(config('admin_code.AdminLoginError'));

        //p($validated);die;

        //设置默认守卫是admin
        Auth::setDefaultDriver('admin');

        if (isset($validated['username']) && isset($validated['password']) && isset($validated['ip']))
        {
            $remember = true; //生成 remmber_token
            /**
             * 注意数据库一旦生成了remember_token,再次登录是不变的,除主动清除或者更新,否则一直存在且不变
             */
            $ip = $validated['ip']; //用户登录日志记录

            $verifyAccountNameResult = 0;
            $verifyEmailResult = 0;
            $verifyPhoneResult = 0;
            //验证账号
            $dataAccountName['account_name'] = $validated['username'];
            $dataAccountName['password'] = $validated['password'];
            $dataAccountName['switch'] = 1;

            $verifyAccountNameResult = Auth::attempt($dataAccountName, $remember);

            //p($verifyAccountNameResult);die;

            //账号验证失败
            if(!$verifyAccountNameResult)
            {
                 //验证邮箱
                $dataEmail['email'] = $validated['username'];
                $dataEmail['password'] = $validated['password'];
                $dataEmail['switch'] = 1;

                $verifyEmailResult = Auth::attempt($dataEmail, $remember);

                //邮箱验证失败
                if(!$verifyEmailResult)
                {
                    //验证手机号
                    $dataPhone['phone'] = $validated['username'];
                    $dataPhone['password'] = $validated['password'];
                    $dataPhone['switch'] = 1;
                    $verifyPhoneResult = Auth::attempt($dataPhone, $remember);
                }
            }

            //有一个验证通过说明是存在的
            if ($verifyAccountNameResult || $verifyEmailResult || $verifyPhoneResult)
            {
                $admin = Auth::user();

                //p($admin);die;

                //无论如何 在redis缓存中执行一边重新再的登录
                $this->checkResetLogin($admin);

                $data['data'] = [];

                if (empty($admin) || !isset($admin->remember_token))
                {
                   throw new CommonException('GetLoginAdminError');
                }

                $data['data']['token'] = $admin->remember_token;

                //adminLogin::dispatch($admin, $ip);
                AdminLoginEvent::dispatch($admin,$validated);

                //登录成功以后 12个小时以后数据库自动退出
                //AdminLogoutJob::dispatchIf($admin->remember_token, $admin)->delay(now()->addSeconds(3600 * 12));
                AdminLogoutJob::dispatchIf($admin->remember_token, $admin)->delay(now()->addSeconds(3600 * 12));

                $result = code(['code'=>0,'msg'=>'登录成功!'], $data);
            }
        }

        return $result;
    }


    /**
     * 获取管理员信息
     *
     * @param  Admin $admin
     */
    public function getAdminInfo(Admin $admin)
    {

        $result = [];

        $data['data'] =
            [
                'introduction' => '',
                'avatar' => '',
                'name' => '',
                'roles' => [],
            ];

        $adminInfoData = null;

        //先检测redis 缓存有没有数据 如果有redis缓存数据
        $redisData = Redis::hget("admin_info:admin_info",$admin->id);

        if(isset($redisData) && !empty($redisData))
        {
            $adminInfoData = \json_decode($redisData,true);
            $data['data'] = $adminInfoData;
        }

        //走到这里说明没redis缓存中没有
        if (!isset($adminInfoData) || empty($adminInfoData))
        {
            $adminInfo = $admin->user->userInfo;

            if (isset($adminInfo->nick_name))
            {
                $data['data']['name'] = $adminInfo->nick_name;
            }

            if (isset($adminInfo->introduction))
            {
                $data['data']['introduction'] = $adminInfo->introduction;
            }

            $data['data']['avatar'] = $this->getAdminAvatar($admin);

            $data['data']['roles'] = $admin->getAdminRoles();

            $redisResult = Redis::hset("admin_info:admin_info",$admin->id,json_encode($data['data']));

            if(!$redisResult)
            {
                Log::debug(['SaveRedisAdminInfoError'=>"redis存储管理员信息失败:{$$admin->id}"]);
            }

        }

        $result = code(['code'=>0,'msg'=>'获取管理员信息成功!'], $data);


        return $result;

    }

    /**
     * 用户退出登录
     *
     * @return void
    */
    public function logout($admin,$ip)
    {
        $result = [];

        $token = $admin->remember_token;

        $admin->remember_token = null;

        //UserUpdateToken
        $logoutResult = $admin->save();

        if (!$logoutResult)
        {
            throw new CommonException('AdminLogoutError');
        }

        AdminLogoutEvent::dispatch($admin, $ip, $token);


        $result = code(['code'=>0,'msg'=>'管理员退出成功!']);

        return $result;
    }




    /**
     * 为了单点登录,执行一边重新再登录逻辑,这样其他设备登录的会自动退出
     *
     * @param  Admin $admin
     */
    private function checkResetLogin(Admin $admin)
    {
        //注意登录时的admin 是数据库admin,所以即使token跟新了,但是redis的token还是原来的token
        $token = $admin->remember_token;



        //先清除redis中的缓存
        $this->clearAdminCache($admin, $token);

        //再更新数据库token
        $newToken = Str::random(60);



        $admin->setRememberToken($newToken);

        $newTokenResult = $admin->save();

        if(!$newTokenResult)
        {
            throw new CommonException('AdminLoginUpdateAdminTokenError');
        }

        //重新将数据存入到 redis中
        $this->loginCache($admin);

    }

    /**
     * 清除管理员缓存
     *
     * @param  Admin  $admin
     * @param  [String] $token
     */
    private function clearAdminCache(Admin $admin, $token)
    {
        Redis::del("admin_token:{$token}");
        Redis::hdel("admin:admin",$admin->id);
        Redis::hdel("admin_info:admin_info",$admin->id);
    }

    /**
     * 登录成功 redis 存储用户相关信息
     *
     * @param Admin $admin
     * @return void
     */
    private function loginCache(Admin $admin)
    {
        //用用户的rember_token 存储用户id 存储12小时
        $tokenResult = Redis::setex("admin_token:{$admin->remember_token}", 12 * 60 * 60, $admin->id);

        //根据用户id 存储用户信息

        //检测是否有用户信息了
        $hasResult = Redis::hget("admin:admin",$admin->id);

        //如果有就先删除
        if($hasResult)
        {
            Redis::hdel("admin:admin",$admin->id);
        }

        $redisResult = Redis::hset("admin:admin",$admin->id,serialize($admin));

        //存储成功以后 将remember_token 和 用户在 redis的id关系 存储 (因为上一个步骤需要用)
        if (!$tokenResult || !$redisResult)
        {
            throw new CommonException('RedisAddAdminError');
        }
    }


    /**
     * 获取所有用户的默认头像 1
     *
     * @return void
     */
    private function getAllUserAvatar()
    {

        $avatar = null;

        $albumPicture = AlbumPicture::find(2);

        if($albumPicture)
        {

            $avatar = asset('storage' . $albumPicture->picture_path .DIRECTORY_SEPARATOR. $albumPicture->picture_file);

            if(config('picture.storage.type') == 20)
            {
                $avatar = $albumPicture->picture_url;
            }
        }

        return $avatar;
    }

    /**
     * 获取管理员头像
     *
     * @param User $user
     * @return void
     */
    private function getAdminAvatar(Admin $admin)
    {
        //远程连接
        $avatar = null;

        $adminAvatar = $admin->user->userAvatar->where('is_default',1)->first();

        if($adminAvatar)
        {
            $albumPicture = $adminAvatar->albumPicture;

            if($albumPicture)
            {
                $avatar = asset('storage' . $albumPicture->picture_path .DIRECTORY_SEPARATOR. $albumPicture->picture_file);

                //存储方式是存储桶
                if(config('picture.storage.type') == 20)
                {
                    $avatar = $albumPicture->picture_url;
                }

            }
        }

        //如果没有头像,就是使用默认头像
        if (!$avatar)
        {
             $avatar = $this->getAllUserAvatar();
        }

        return  $avatar;
    }
}
