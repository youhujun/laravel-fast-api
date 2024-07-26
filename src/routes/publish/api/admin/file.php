<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 19:39:56
 * @FilePath: \routes\api\admin\file.php
 */

/**模板路由 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$namespace = 'App\\Http\\Controllers\\Admin\\File';

/**
 * 后端模版
 */
 Route::prefix(config('custom.version'))->namespace($namespace)->middleware('admin.login')->group(function()
{
    Route::prefix('admin')->group(function()
    {

		    /**
            * bind
            * @see \App\Http\Controllers\Admin\File\UploadController
           */
            Route::controller(UploadController::class)->group(function()
            {
               // 后台上传配置文件
                Route::post('uploadConfigFile','uploadConfigFile');

                //单图片上传
                Route::post('uploadSinglePicture','uploadSinglePicture');

                //多图片上传
                Route::post('uploadMultiplePicture','uploadMultiplePicture');

                //上传头像
                Route::post('uploadUserAvatar','uploadUserAvatar');

                //图片空间替换上传
                Route::post('uploadResetPicture','uploadResetPicture');

                //上传Excel
                Route::post('uploadExcel','uploadFile');

            });

             /**
                *
                * bind
                * @see \App\Http\Controllers\Admin\File\DownloadController
                */
                Route::controller(DownloadController::class)->group(function()
                {
                    //下载银行模板
                    Route::post('downloadBank','downloadBank');
                });


   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});


