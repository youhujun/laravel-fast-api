<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-27 10:40:52
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-08-01 12:27:53
 * @FilePath: \app\Service\Facade\Phone\Login\PhoneLoginFacadeService.php
 */

namespace App\Service\Facade\Phone\Login;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use App\Exceptions\Phone\CommonException;

use App\Events\Phone\CommonEvent;
use App\Events\Phone\User\UserLoginEvent;
use App\Events\Phone\User\UserRegisterEvent;
use App\Events\Phone\User\UserLogoutEvent;

use App\Models\User\User;
use App\Models\Picture\AlbumPicture;
use App\Models\User\UserWechat;

use App\Facade\Public\Sms\SmsFacade;


/**
 * @see \App\Facade\Phone\Login\PhoneLoginFacade
 */
class PhoneLoginFacadeService
{
   public function test()
   {
       echo "PhoneLoginFacadeService test";
   }

   /**
    * 通过手机号 密码登录
    *
    * @param array $validated
    * @return void
    */
   public function loginByUser($validated = [])
   {
        $result = code(config('phone_code.LoginByUserError'));

        if(isset($validated['phone'])&& isset($validated['password']) && isset($validated['ip']))
        {
            //设置默认守卫是phone
            Auth::setDefaultDriver('phone');

            $remember = true;//生成 remmber_token

            $ip = $validated['ip']; //用户登录日志记录

            //验证手机号
            $dataPhone['phone'] =  $validated['phone'];
            $dataPhone['password'] =  $validated['password'];
            $dataPhone['switch'] = 1;
            $verifyPhoneResult = Auth::attempt($dataPhone,$remember);

             //有一个验证通过说明是存在的
            if (!$verifyPhoneResult)
            {
               throw new CommonException('LoginByUserError');
            }

            $user = Auth::user();

            $result = $this->commonLoginByPhone($dataPhone['phone'],$ip,$user);
        }

         return $result;
   }

   /**
    * 发送验证码
    *
    * @param array $validated
    * @return void
    */
   public function sendVerifyCode($validated = [])
   {
        $result = code(config('phone_code.SendPhoneCodeError'));

        if(isset($validated['phone']) && !empty($validated['phone']))
        {
           $sendResult = SmsFacade::sendVerifyCode($validated['phone']);

           if($sendResult)
           {
              $result =  code(['code'=>0,'msg'=>'短信验证码发送成功!']);
           }
        }

        return $result;
   }

   /**
    * 通过手机号验证码登录
    *
    * @param array $validated
    * @return void
    */
   public function loginByPhone($validated = [])
   {
        $result = code(config('phone_code.LoginByPhoneError'));

        if(isset($validated['phone'])&& isset($validated['code']) && isset($validated['ip']))
        {
            //先获取验证码并进行比对
            $code = SmsFacade::getVerifyCode($validated['phone']);

            if($code != $validated['code'])
            {
                throw new CommonException('PhoneCodeError');
            }

            $phone = $validated['phone'];

            $ip = $validated['ip']; //用户登录日志记录

            //验证手机号 是否有手机用户
            $user = User::where([['phone','=',$phone],['switch','=',1]])->first();

            if(!$user)
            {
               throw new CommonException('PhoneUserError');
            }

            //登录
            $result = $this->commonLoginByPhone($phone,$ip,$user);
        }

        return $result;
   }

   /**
	* 重置手机密码
    */
   public function restPasswordByPhone($validated = [])
   {
		$result = code(\config('phone_code.RestPasswordByPhoneError'));

		if(!isset($validated['phone']) || !isset($validated['code']) || !isset($validated['password']))
		{
			throw new CommonException('ParamsIsNullError');
		}

		//先获取验证码并进行比对
		$code = SmsFacade::getVerifyCode($validated['phone']);

		if($code != $validated['code'])
		{
			throw new CommonException('PhoneCodeError');
		}

		$user = User::where('phone',$validated['phone'])->first();

		if(!$user)
		{
			throw new CommonException('RestPasswordPoneIsNullError');
		}

		$password = $validated['password'];

		$user->password = Hash::make($password);

		$userResult = $user->save();

		if(!$userResult)
		{
			throw new CommonException('RestPasswordByPhoneError');
		}

		CommonEvent::dispatch($user,$validated,'RestPasswordByPhone');

		$result = ['code'=>0 ,'msg'=>'重置密码成功!'];

		return $result;
   }

   /**
    * 内部通过手机号登录
    *
    * @param [type] $phone
    * @param [type] $ip
    * @param string $password
    * @return void
    */
   protected function commonLoginByPhone($phone,$ip,$user = null)
   {
        Auth::setDefaultDriver('phone');

        $remember = true;//生成 remmber_token

        if(optional($user)->phone)
        {
            //如果有手机号 直接登录
            Auth::login($user,$remember);
        }
        else
        {
            //注册登录
            //验证手机号
            $dataPhone['phone'] =  $phone;
            $dataPhone['password'] = 'abc123';
            $dataPhone['switch'] = 1;

            $verifyPhoneResult = Auth::attempt($dataPhone,$remember);

            if(!$verifyPhoneResult)
            {
                throw new CommonException('LoginPhoneError');
            }

            $user = Auth::user();

        }

        //验证现在这个用户是否是登录状态
        $this->checkResetLogin($user);

        $data['data'] = [];

        if(!empty($user) && isset($user->remember_token))
        {
            $data['data']['token'] = $user->remember_token;
        }

        // 20是 用户登录 source
        UserLoginEvent::dispatch($user,$ip);

        $result = code(['code'=> 0,'msg'=>'用户登录成功!'],$data);

        return $result;
   }

   /**
    * 通过三大运营商一键登录
    *
    * @param array $validated
    * @return void
    */
   public function univerifyLogin($validated = [])
   {
        $result = code(config('phone_code.LoginUniVerifyError'));

        // Log::debug(['validated'=>$validated]);

        $ip = '127.0.0.1';

        if(isset($validated['ip']))
        {
            $ip = $validated['ip'];
        }

        //先处理手机端传递过来的参数 获取手机号
        $sercret = trim(Cache::store('redis')->get('uni_app.univerifyLogin.sercret'));

        if(!$sercret)
        {
            throw new CommonException('LoginUniVerifyNoSercretError');
        }

        $hamc = hash_init('sha256',1, $sercret);

        if(!(isset($validated['openid']) && isset($validated['access_token'])))
        {
            throw new CommonException('LoginUniVerifyParamError');
        }

        $singStr = "access_token={$validated['access_token']}&openid={$validated['openid']}";

        hash_update($hamc, $singStr);

        $sign = \hash_final($hamc);

        //Log::debug(['sign'=>$sign]);

        $uni_app_cloud_url = trim(Cache::store('redis')->get('uni_app.univerifyLogin.url'));

        if(!$uni_app_cloud_url)
        {
            throw new CommonException('LoginUniVerifyNoCloudUrlError');
        }

        $loginUrl = $uni_app_cloud_url."?{$singStr}&sign=${sign}";

        // Log::debug(['url'=>$loginUrl]);

        $loginResult = httpGet($loginUrl);

        // Log::debug(['$loginResult'=>$loginResult]);

        //如果不为空才算成功
        if(!empty($loginResult))
        {
            $loginResultArray = \json_decode($loginResult,true);

            if($loginResultArray['code'] != 0 || !$loginResultArray['success'])
            {
                throw new CommonException('LoginUniVerifyError');
            }

            $phone = $loginResultArray['phoneNumber'];

            //获取到手机号以后,有两种情况 一种是注册 再登录 一种是直接登录

            //先判断手机号是否在数据库中
            $user = User::withTrashed()->where('phone',$phone)->first();

            if($user)
            {
                if($user->switch == 1 && $user->deleted_at == null)
                {
                    //登录
                    $result = $this->commonLoginByPhone($phone,$ip,$user);
                }
                else
                {
                     throw new CommonException('LoginUniVerifyDisabledUserError');
                }

            }
            else
            {
                //注册
                DB::beginTransaction();

                $user = new User;

                $user->phone = $validated['phone'];

                $user->password = Hash::make('abc123');

                //用户级别最低
                $user->level_id = 1;

                //用户未实名认证
                $user->real_auth_status = 10;

                $user->switch = 1;

                $user->created_at = time();

                $user->created_time = time();

                $user->account_name = \bin2hex(\random_bytes(4));

                $user->auth_token = Str::random(20);

                $userResult = $user->save();

                // 邀请码
                $user_id = $user->id;

                if(mb_strlen($user_id) < 4)
                {
                    $user->invite_code = str_pad($user_id,4,'0',STR_PAD_LEFT);
                }
                else
                {
                    $user->invite_code = $user_id;
                }

                $userResult = $user->save();

                if(!$userResult)
                {
                    DB::rollBack();
                    throw new CommonException('AddUserByUniverifyError');
                }

                UserRegisterEvent::dispatch($user,$validated,1);

                CommonEvent::dispatch($user,$validated,'AddUserByUniverify',1);

                //提交
                DB::commit();

                //登录
                $result = $this->commonLoginByPhone($phone,$ip);
            }

        }

        //Log::debug(['$result'=>$result]);

        return $result;

   }

   /**
    * 通过用户id登录 默认已经绑定微信的openid
    *
    * @param  array $validated
    */
   public function loginByUserId($validated = [])
   {
        $result = code(config('phone_code.LoginByUserIdError'));

        if(isset($validated['user_id']))
        {
            $user = User::find($validated['user_id']);

            if($user)
            {
                Auth::setDefaultDriver('phone');

                $remember = true;

                Auth::login($user,$remember);

                //验证现在这个用户是否是登录状态
                $this->checkResetLogin($user);

                $ip = "127.0.0.1";

                if(isset($validated['ip']))
                {
                    $ip = $validated['ip'];
                }

                UserLoginEvent::dispatch($user,$ip);

                $data['data']['token'] = $user->remember_token;
                $data['data']['user_id'] = $user->id;
                $data['data']['openid'] = $this->getUserOpenid($user);

                $result = code(['code'=> 0,'msg'=>'用户登录成功!'],$data);
            }
        }

        return $result;
   }

    /**
     * 用户退出登录
     *
     * @return void
     */
    public function logout($ip)
    {
        $result = code(config('phone_code.LogoutError'));

        $user = Auth::guard('phone_token')->user();

        $token = $user->remember_token;

        $user->remember_token = null;

        //UserUpdateToken
        $logoutResult = $user->save();

        if(!$logoutResult)
        {
            throw new CommonException('LogoutError');
        }

        UserLogoutEvent::dispatch($user, $ip, $token);

        $result = code(['code'=> 0 ,'msg'=>'用户退出登录成功!']);

        return $result;
    }

    /**
     * 存储用户详情
     *
     * @param User $user
     * @param [type] $userInfo
     * @return void
     */
    public function cacheUserInfo(User $user, $userInfo)
    {
        $result = Redis::hset("phone_user_info:user_info",$user->id,convertToString($userInfo));

        return $result;
    }

    /**
     * 登录用户获取信息
     *
     * @return void
     */
    public function getUserInfo(User $user)
    {
        $result = code(config('phone_code.GetUserInfoError'));

        $data = [
                'user_id'=>null,
                'introduction' => '',
                'avatar' => '',
                'name' => '',
                'roles' => [],
                'phone' => '',
                'created_at' => '',
                'sex' => 0,
                'real_auth_status' => 10,
                'openid' => null
            ];

        $userInfoData = null;

        //先检测redis 缓存有没有数据 如果有redis缓存数据
        $redisData = Redis::hget("phone_user_info:user_info",$user->id);

        if(isset($redisData) && !empty($redisData))
        {
            $userInfoData = \json_decode($redisData);
            $data = $userInfoData;
        }

        //走到这里说明没redis缓存中没有
        if (!isset($userInfoData) || empty($userInfoData))
        {
            $data['user_id'] = $user->id;

            $userInfo = $user->userInfo;

            if (isset($userInfo->nick_name))
            {
                $data['name'] = $userInfo->nick_name;
            }

            if (isset($userInfo->introduction))
            {
                $data['introduction'] = $userInfo->introduction;
            }

            $data['avatar'] = $this->getUserAvatar($user);

            $data['roles'] = $user->getRoles();

            $data['phone'] = $user->phone;

            $data['created_at'] = $user->created_at;

            $data['real_auth_status'] = $user->real_auth_status;

            $data['openid'] = $this->getUserOpenid($user);

            if (isset($userInfo->sex))
            {
                $data['sex'] = $userInfo->sex;
            }

            Redis::hset("phone_user_info:user_info",$user->id,json_encode($data));

        }

        $result = code(['code'=> 0,'msg'=>'获取用户信息成功'], ['data'=>$data]);

        return $result;
    }

	/**
	 * 微信登录后绑定手机
	 *
	 * @param  [type] $validated
	 * @param  [type] $user
	 */
	public function bindPhone($validated,$user)
	{
		$result = code(config('phone_code.UserBindPhoneError'));

		if(!isset($validated['phone']) || !isset($validated['code']) || !isset($validated['password']))
		{
			throw new CommonException('ParamsIsNullError');
		}

		//先获取验证码并进行比对
		$code = SmsFacade::getVerifyCode($validated['phone']);

		if($code != $validated['code'])
		{
			throw new CommonException('PhoneCodeError');
		}

		$phone = $validated['phone'];

		$password =  $validated['password'];

		//绑定手机和密码

		$user->phone = $phone;

		$user->password = Hash::make($password);

		$userResult = $user->save();

		if(!$userResult)
		{
			throw new CommonException('UserBindPhoneError');
		}

		CommonEvent::dispatch($user,$validated,'UserBindPhone');

		$result = ['code'=>0 ,'msg'=>'用户绑定手机号成功!','phone'=> $phone];

		return $result;
	}

    /**
    * 清楚用户相关缓存
    *
    * @param User $user
    * @param [type] $token
    * @return void
    */
   protected function clearUserCache(User $user,$token)
   {
       Redis::del("phone_user_token:{$token}");
       Redis::hdel("phone_user:user",$user->id);
       Redis::hdel("phone_user_info:user_info",$user->id);
   }

       /**
    * 登录成功 redis 存储用户相关信息
    *
    * @param User $user
    * @return void
    */
   protected function loginCache(User $user)
   {
         //存储用户 特别是 remember_token
         //根据用户id 存储 用户token  24小时
         $tokenResult = Redis::set("phone_user_token:{$user->remember_token}",$user->id);

         //检测是否有用户信息了
        $hasResult = Redis::hget("phone_user:user",$user->id);

        //如果有就先删除
        if($hasResult)
        {
            Redis::hdel("phone_user:user",$user->id);
        }

         //存储用户信息 然后获取 该用户在redis 的id
         $redisResult =  Redis::hset("phone_user:user",$user->id,convertToString($user));

         //存储成功以后 将remember_token 和 用户在 redis的id关系 存储 (因为上一个步骤需要用)
         if(!$tokenResult || !$redisResult )
         {
             throw new CommonException('RedisAddUserError');
         }

   }
    /**
    * 检测是否登录了,如果登录了,跟新token,让其他人重新登录
    *
    * @param User $user
    * @return void
    */
   protected function checkResetLogin(User $user)
   {
        //注意登录时的user 是数据库user,所以即使token跟新了,但是redis的token还是原来的token
        $token = $user->remember_token;

        //先清除redis中的缓存
        $this->clearUserCache($user, $token);

        //再更新数据库token
        $newToken = Str::random(60);

        $user->setRememberToken($newToken);

        $newTokenResult = $user->save();

        //重新将数据存入到 redis中
        $this->loginCache($user);

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
    private function getUserAvatar(User $user)
    {
        //远程连接
        $avatar = null;

        $userAvatar = $user->userAvatar->where('is_default',1)->first();

        if($userAvatar)
        {
            $albumPicture = $userAvatar->albumPicture;

            if($albumPicture)
            {
                if($albumPicture->picture_type == 0 || $albumPicture->picture_type == 10)
                {
                    $avatar = asset('storage' . $albumPicture->picture_path .DIRECTORY_SEPARATOR. $albumPicture->picture_file);
                }

                if($albumPicture->picture_type == 30)
                {
                    $avatar = $albumPicture->picture_url;
                }


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

     /**
     * 获取用户微信的openid
     *
     * @param User $user
     * @return void
     */
    private function getUserOpenid(User $user)
    {
        $openid = null;

        $userWechat = UserWechat::where('user_id',$user->id)->first();

        if($userWechat)
        {
            if(isset($userWechat->openid) && $userWechat->openid)
            {
                $openid = $userWechat->openid;
            }
        }

        return $openid;
    }
}
