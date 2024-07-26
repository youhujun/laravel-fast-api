<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-07 10:25:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 19:21:17
 * @FilePath: \app\Service\Facade\Public\Wechat\WechatOfficialFacadeService.php
 */

namespace App\Service\Facade\Public\Wechat;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use App\Exceptions\Common\CommonException;

use App\Events\Phone\CommonEvent;
use App\Events\Phone\User\Wechat\WechatOfficialRegisterEvent;
use App\Events\Phone\User\Wechat\WechatOfficialBindUserOpenidEvent;
use App\Events\Phone\User\UserLoginEvent;

use App\Models\User\UserWechat;
use App\Models\User\User;


/**
 * @see \App\Facade\Public\Wechat\WechatOfficialFacade
 */
class WechatOfficialFacadeService
{
   public function test()
   {
       echo "WechatOfficialFacadeService test";
   }

   protected $app;

   //微信公众号id
   protected $wechat_official_appid;
   //微信公众号秘钥
   protected $wechat_official_appsercet;
   protected $wechat_official_redirect_url;
   protected $wechat_official_scope_array  = [10=>'snsapi_base',20=>'snsapi_userinfo'];
   protected $wechat_official_scope;

    /**
    * 初始化
    *
    * @param [type] $scopeIndex
    * @return void
    */
   private function init($scope_type)
   {

      $this->wechat_official_appid = trim(Cache::store('redis')->get('wechat.official.appId'));

      if(!$this->wechat_official_appid)
      {
         throw new CommonException('WechatOfficialAppIdError');
      }

      $this->wechat_official_appsercet =  trim(Cache::store('redis')->get('wechat.official.appSercet'));

      if(!$this->wechat_official_appsercet)
      {
         throw new CommonException('WecahtOfficialAppSercetError');
      }

      $this->wechat_official_redirect_url = urlencode(trim(Cache::store('redis')->get('wechat.official.auth_redirect_url')));

      if(!$this->wechat_official_redirect_url)
      {
        throw new CommonException('WechatOfficialAuthRedirectUrlError');
      }

      $this->wechat_official_scope = $this->wechat_official_scope_array[$scope_type];

   }

   /**
    * Undocumented function
    *
    * @param  [type] $scope_type 10静默授权 20获取用户信息
    */
   public function wechatOfficialGetCode($scope_type)
   {
        $result =  code(config('common_code.WechatOfficialGetCodeError'));

        $this->init($scope_type);

        $appid =   $this->wechat_official_appid;

        $urlNow =  $this->wechat_official_redirect_url;

        $scope =   $this->wechat_official_scope;

        $state = 10;

        if($scope_type == 20)
        {
            $state = 20;
        }

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$urlNow}&response_type=code&scope={$scope}&state={$state}&connect_redirect=1#wechat_redirect";

        // Log::debug(['$url'=>$url]);

        $data['url'] = $url;

        $result =  code(['code'=> 0,'msg'=>'微信公众号发起授权成功!'],['data'=>$data]);

        return $result;
   }

   /**
    * 微信公众号授权
    *
    * @param  [type] $validated
    */
   public function  wechatOfficialAuth($validated)
   {
        $result =  code(config('common_code.WechatOfficialAuthError'));

        $scope_type = 10;

        if(isset($validated['scope_type']))
        {
            $scope_type = $validated['scope_type'];
        }

        $this->init($scope_type);

        $appid =   $this->wechat_official_appid;

        $appsercet = $this->wechat_official_appsercet;

        $code='';

        if(isset($validated['code']))
        {
            $code = $validated['code'];
        }

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsercet}&code={$code}&grant_type=authorization_code";

        $authResult = json_decode(httpGet($url));

        //p($authResult);die;

        /**
         * 错误示例:
         *  '$authResult' =>
            (object) array(
                'errcode' => 40029,
                'errmsg' => 'invalid code, rid: 64ad1b16-27f70e5c-449d5468',
            ),
         */
         /**正确示例
         * {
            "access_token":"ACCESS_TOKEN",
            "expires_in":7200,
            "refresh_token":"REFRESH_TOKEN",
            "openid":"OPENID",
            "scope":"SCOPE"
            }
         */
         //Log::debug(['$authResult'=>$authResult]);

         //检测是否报错
         $checkResult = property_exists($authResult,'errcode');

         //p($checkResult);

         if($checkResult)
         {
             $result =  code(config('common_code.WechatOfficialAuthError'),['data'=>['errcode'=>$authResult->errcode,'msg'=> $authResult->errmsg]]);
         }
         else
         {
            $openid = $authResult->openid;

            $access_token = $authResult->access_token;

            $wechat_official_appid = $this->wechat_official_appid;

             //静默授权
             if($scope_type === 10)
             {
                DB::beginTransaction();

                $user = Auth::guard('phone_token')->user();

                $params = ['wechat_official_appid'=>$wechat_official_appid,'openid'=>$openid];

                WechatOfficialBindUserOpenidEvent::dispatch($user,$params,1);

                DB::commit();

                $result =  code(['code'=> 0,'msg'=>'获取微信公众号授权成功!'],['data'=>['openid'=>$openid]]);
             }

             //主动授权 用户信息
             if($scope_type === 20)
             {
                //获取用户信息
                $userInfoResult = $this->getWechatOfficialUserInfo($access_token,$openid);

                $userInfoCheckResult = property_exists($userInfoResult,'openid');

                //Log::debug(['$userInfoResult'=>$userInfoResult]);

                if($userInfoCheckResult)
                {
                    $nickname = $userInfoResult->nickname;

                    $sex = $userInfoResult->sex;

                    $headimgurl = $userInfoResult->headimgurl;

                    $openid = $userInfoResult->openid;

                    $where= [];
                    $where[] = ['openid','=',$openid];
                    $where[] = ['wechat_official_appid','=',$wechat_official_appid];

                    $userWechat = UserWechat::where($where)->first();

                    //没有就注册用户,再登录
                    if(!$userWechat)
                    {
                        DB::beginTransaction();

                        $user = new User;

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
                            throw new CommonException('WechatOfficialAddUserError');
                        }

                        $params = ['nick_name'=>$nickname,'sex'=>$sex,'user_avatar_url'=>$headimgurl,'wechat_official_appid'=>$wechat_official_appid,'openid'=>$openid];

                        WechatOfficialRegisterEvent::dispatch($user,$params,1);
                        WechatOfficialBindUserOpenidEvent::dispatch($user,$params,1);

                        CommonEvent::dispatch($user,$params,'WechatOfficialAddUser',1);

                        DB::commit();
                    }
                    else
                    {
                        DB::beginTransaction();
                        //有用户
                        $user = User::find($userWechat->user_id);

                        if(!$user)
                        {
                            DB::rollBack();
                            throw new CommonException('WechatOfficialFindUserError');
                        }

                        $params = ['wechat_official_appid'=>$wechat_official_appid,'openid'=>$openid];

                        WechatOfficialBindUserOpenidEvent::dispatch($user,$params,1);

                        DB::commit();
                    }

                    //执行用户登录
                    $remember = true;//生成 remmber_token

                    Auth::login($user,$remember);

                    //验证现在这个用户是否是登录状态
                    $this->checkResetLogin($user);

                    $ip = '127.0.0.1';
                    if(isset($validated['ip']))
                    {
                        $ip = $validated['ip'];
                    }

                    UserLoginEvent::dispatch($user,$ip);

                }

                $result =  code(['code'=> 0,'msg'=>'微信公众号登录成功!'],['data'=>['openid'=>$openid,'token'=>$user->remember_token]]);
             }

         }

        return $result;
   }

   /**
    * 获取用户信息
    *
    * @param  [type] $access_token
    * @param  [type] $openid
    */
   private function getWechatOfficialUserInfo($access_token,$openid)
   {

        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";

        $userInfoResult = json_decode(httpGet($url));

        /**
         * {
                "openid": "OPENID",
                "nickname": NICKNAME,
                "sex": 1,
                "province":"PROVINCE",
                "city":"CITY",
                "country":"COUNTRY",
                "headimgurl":"https://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
                "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
                "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
            }

         */

        return $userInfoResult;
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


}
