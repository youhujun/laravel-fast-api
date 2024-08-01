<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-08-01 12:14:00
 * @FilePath: \routes\api\phone\login.php
 */

/**模板路由 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$namespace = 'App\\Http\\Controllers\\Phone';

/**
 * 手机模版
 */
Route::prefix(config('custom.version'))->namespace($namespace)->middleware('phone.login')->group(function()
{
   Route::prefix('phone')->group(function()
    {

        Route::namespace('Login')->group(function()
        {
            /**
             * @see \App\Http\Controllers\Phone\Login\LoginController
             */
            Route::controller(LoginController::class)->group(function()
            {
                //用户名密码登录
                Route::post('loginByUser','loginByUser')->withoutMiddleware('phone.login');

                //发送验证码
                Route::any('sendVerifyCode','sendVerifyCode')->withoutMiddleware('phone.login');
                //通过手机验证码登录
                Route::post('loginByPhone','loginByPhone')->withoutMiddleware('phone.login');

				//发送验证码 忘记密码
                Route::any('sendPasswordCode','sendPasswordCode')->withoutMiddleware('phone.login');

				//重置手机密码
				Route::post('restPasswordByPhone','restPasswordByPhone')->withoutMiddleware('phone.login');

                //微信公众号登录-1获取授权链接
                Route::any('wechatOfficialGetCodeByLogin','wechatOfficialGetCodeByLogin')->withoutMiddleware('phone.login');
                //微信公众号登录-2授权页授权
                Route::any('wecahtOfficialAuthToLogin','wecahtOfficialAuthToLogin')->withoutMiddleware('phone.login');

                //一键登录
                Route::any('univerifyLogin','univerifyLogin')->withoutMiddleware('phone.login');

                //通过用户id登录,开发测试用
                Route::any('loginByUserId','loginByUserId')->withoutMiddleware('phone.login');

                //微信公众号登录成功以后静默授权-1获取授权链接
                Route::any('wechatOfficialGetCode','wechatOfficialGetCode');
                //微信公众号登录成功以后静默授权-2授权页授权
                Route::any('wecahtOfficialAuth','wecahtOfficialAuth');

                //获取用户信息
                Route::get('getUserInfo','getUserInfo');

                //检测是否登录
                Route::any('checkIsLogin','checkIsLogin');

				//发送绑定验证码
                Route::any('sendBindCode','sendBindCode')->withoutMiddleware('phone.login');
				//绑定手机号
				Route::post('bindPhone','bindPhone');

                //退出
                Route::any('logout','logout');
            });

            /**
             * 注册
             * bind
             * @see \App\Http\Controllers\Phone\Login\RegisterController
            */
            Route::controller(RegisterController::class)->group(function()
            {
                //发送用户注册码
                Route::any('sendUserRegisterCode','sendUserRegisterCode')->withoutMiddleware('phone.login');

                //用户注册
                Route::post('userRegister','userRegister')->withoutMiddleware('phone.login');

            });

        });


   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});


