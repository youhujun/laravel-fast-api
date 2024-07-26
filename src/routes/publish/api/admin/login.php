<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-24 20:31:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 23:23:14
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\routes\api\admin\login.php
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$namespace = 'App\\Http\\Controllers\\Admin\\Login';

/**
 * 后端模版
 */
 Route::prefix(config('custom.version'))->namespace($namespace)->middleware('admin.login')->group(function()
{
    Route::prefix('admin')->group(function()
    {
		 /**
            * bind
            * @see \App\Http\Controllers\Admin\Login\AdminLoginController
           */
            Route::controller(AdminLoginController::class)->group(function()
            {
                //获取
                Route::post('login','login')->withoutMiddleware('admin.login');
                //开发者登录--开发工作用
                Route::post('loginYouhu','login')->withoutMiddleware('admin.login');

                //获取登录用户信息
                Route::get('getAdminInfo','getAdminInfo');

                //获取系统属性路由
                Route::get('getTreePermission','getTreePermission');

                //退出
                Route::get('logout','logout');

            });

   });
});

Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});
