<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-30 23:14:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-28 08:05:45
 */

namespace YouHuJun\LaravelFastApi\App\Providers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //dd($this->app['config']);die;
     
        $this->app->make('config')->set('auth.providers.user.model','\App\Models\User\User');
        $this->app->make('config')->set('auth.providers.admin.model','\App\Models\Admin\Admin');
      
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        //自定义闭包guard 对应 api_token 后台 
        Auth::viaRequest('Admin-Token', function ($request) 
		{

            $api_token = $request->header('X-Token');

            $admin = null;

            if($api_token)
            {
                //先从redis 缓存获取 用户
                $admin = $this->getAdminUserByToken($api_token);

                if(empty( $admin) || !isset($admin))
                {
                    //如果缓存不存在 表示用户已经退出了,重新从数据库获取
                    $admin =  \App\Models\Admin\Admin::where('remember_token', $api_token)->first();

                }
            }
            
            return $admin;
        });

		//自定义闭包guard  phone_token 手机端
        Auth::viaRequest('Phone-Token', function ($request) 
		{

            $api_token = $request->header('X-Token');

            $user = null;

            if($api_token)
            {
                //先从redis 缓存获取 用户
                $user = $this->getPhoneUserByToken($api_token);

                if(empty( $user) || !isset($user))
                {
                    //如果缓存不存在 表示用户已经退出了,重新从数据库获取
                  
                    $user =  \App\Models\User\User::where('remember_token', $api_token)->first();
                }
            }
            
            return $user;
        });

    }

	/**
     * 通过token 获取redis后台用户
     *
     * @param [type] $remember_token
     * @return void
     */
    public function getAdminUserByToken($remember_token)
    {
        $result = null;

        $existsResult = Redis::exists("admin_token:{$remember_token}");

        if($existsResult)
        {
            $adminId = Redis::get("admin_token:{$remember_token}");

            if ($adminId  && \is_numeric($adminId))
            {
                $redisAdmin = Redis::hget("admin:admin",$adminId);

                if (isset($redisAdmin) && !empty($redisAdmin))
                {
                    $admin = null;

					$admin = \unserialize($redisAdmin);
					
                    $result =  $admin;
                }
            }
        }

        return $result;
    }

	/**
     * 通过token 获取redis手机用户
     *
     * @param [type] $remember_token
     * @return void
     */
    public function getPhoneUserByToken($remember_token)
    {
        $result = null;

        $existsResult = Redis::exists("phone_user_token:{$remember_token}");

        if($existsResult)
        {

            $userId = Redis::get("phone_user_token:{$remember_token}");

            if ($userId  && \is_numeric($userId))
            {
                $redisUser = Redis::hget("phone_user:phone_user",$userId);

                if (isset($redisUser) && !empty($redisUser))
                {
                    $user = null;

                    if (\is_serialized($redisUser))
                    {
                        $user = \unserialize($redisUser);
                    } else {
                        $user = \json_decode($redisUser);
                    }
                    $result =  $user;
                }
            }
        }

        return $result;
    }

	

}
