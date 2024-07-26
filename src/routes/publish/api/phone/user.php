<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 18:33:26
 * @FilePath: \routes\api\phone\user.php
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
        Route::namespace('User\\User')->group(function()
        {
            /**
             * 手机端用户控制器
             * @see \App\Http\Controllers\Phone\User\User\UserController.php
             */
            Route::controller(UserController::class)->group(function()
            {
                //申请实名认证
                Route::post('realAuthApply','realAuthApply');
            });

            Route::namespace('My')->group(function()
            {
                /**
                 *@see \App\Http\Controllers\Phone\User\User\My\ConfigController
                 */
                Route::controller(ConfigController::class)->group(function()
                {
                    //清理用户缓存
                    Route::any('clearUserCache','clearUserCache');
                });
            });
        });
   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});
