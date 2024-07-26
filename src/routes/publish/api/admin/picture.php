<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-01 22:36:28
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 11:31:14
 * @FilePath: \routes\api\admin\picture.php
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$namespace = 'App\\Http\\Controllers\\Admin\\Picture';

/**
 * 后端模版
 */
 Route::prefix(config('custom.version'))->namespace($namespace)->middleware('admin.login')->group(function()
{
    Route::prefix('admin')->group(function()
    {
        /**
         * 相册
        * bind
        * @see \App\Http\Controllers\Admin\Picture\AlbumController
        */
        Route::controller(AlbumController::class)->group(function()
        {
            //获取相册
            Route::post('getAlbum','getAlbum');
            //添加相册
            Route::post('addAlbum','addAlbum');
            //更新相册
            Route::post('updateAlbum','updateAlbum');
            //删除相册
            Route::post('deleteAlbum','deleteAlbum');
            //获取相册图片
            Route::post('getAlbumPicture','getAlbumPicture');

            //获取默认选项
            Route::post('getDefaultAlbum','getDefaultAlbum');
            //查找默认相册
            Route::post('findAlbum','findAlbum');

        });

        /**
         * 相册图片
        * bind
        * @see \App\Http\Controllers\Admin\Picture\PictureController
        */
        Route::controller(PictureController::class)->group(function()
        {

            //设为封面
            Route::post('setCover','setCover');

            //转移相册
            Route::post('moveAlbum','moveAlbum');

            //批量转移相册
            Route::post('moveMultipleAlbum','moveMultipleAlbum');

            //删除图片
            Route::post('deletePicture','deletePicture');

            //批量删除图片
            Route::post('deleteMultiplePicture','deleteMultiplePicture');

            //更新图片名称
            Route::post('updatePictureName','updatePictureName');

        });
    });
});

Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});
