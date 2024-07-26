<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 10:31:28
 * @FilePath: \routes\api\phone\notify.php
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
        Route::namespace('Notify')->group(function()
        {
            //支付回调
            Route::namespace('Pay')->group(function()
            {
                //微信支付回调
                Route::namespace('Wechat')->group(function()
                {
                    /**
                     * 微信支付回调
                     * @see \app\Http\Controllers\Phone\Notify\Pay\Wechat\NotifyController
                     */
                    Route::controller(NotifyController::class)->group(function()
                    {
                        //H5的JsPay回调
                        Route::any('wechatJsPayNotify','wechatJsPayNotify')->withoutMiddleware('phone.login');
                    });
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
