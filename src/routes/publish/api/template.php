<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-27 10:24:29
 * @FilePath: \routes\api\template.php
 */

/**模板路由 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$namespace = 'App\\Http\\Controllers';

/**
 * 后端模版
 */
 Route::prefix(config('custom.version'))->namespace($namespace)->middleware('admin.login')->group(function()
{
    Route::prefix('admin')->group(function()
    {

		 /**
            * bind
            * @see \App\Http\Controllers\ReplaceController
           */
            Route::controller(ReplaceController::class)->group(function()
            {
                //获取
                Route::any('getReplace','getReplace');
                //添加
                Route::any('addReplace','addReplace');

                //更新
                Route::any('updateReplace','updateReplace');

                //删除
                Route::any('deleteReplace','deleteReplace');

                //批量删除
                Route::any('multipleDeleteReplace','multipleDeleteReplace');

            });

   });
});

/**
 * 手机模版
 */
Route::prefix(config('custom.version'))->namespace($namespace)->middleware('phone.login')->group(function()
{
   Route::prefix('phone')->group(function()
    {

		 /**
            * bind
            * @see \App\Http\Controllers\ReplaceController
           */
            Route::controller(ReplaceController::class)->group(function()
            {
                //获取
                Route::any('getReplace','getReplace');
                //添加
                Route::any('addReplace','addReplace');

                //更新
                Route::any('updateReplace','updateReplace');

                //删除
                Route::any('deleteReplace','deleteReplace');

                //批量删除
                Route::any('multipleDeleteReplace','multipleDeleteReplace');

            });

   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});


