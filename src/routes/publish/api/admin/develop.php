<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-24 20:31:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 19:11:16
 * @FilePath: \routes\api\admin\develop.php
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$namespace = 'App\\Http\\Controllers\\Admin\\Develop';

/**
 * 后端模版
 */
 Route::prefix(config('custom.version'))->namespace($namespace)->middleware('admin.login')->group(function()
{
    Route::prefix('admin')->group(function()
    {
		 /**
            * bind
            * @see \App\Http\Controllers\Admin\Develop\DevelopController
           */
            Route::controller(DevelopController::class)->group(function()
            {
                //获取
                Route::post('addDeveloper','addDeveloper');
            });

   });
});

Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});
