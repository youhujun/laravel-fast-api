<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-11 09:24:57
 * @FilePath: \routes\api\phone\file.php
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
        Route::namespace('File')->group(function()
        {
            /**
             * 文件控制器 单图上传
             * @see \App\Http\Controllers\Phone\File\FileController
             */
            Route::controller(FileController::class)->group(function()
            {
                //单图上传 多图上传就是重复调用该接口
                Route::post('singleUploadPicture','singleUploadPicture');
            });
        });
   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});
