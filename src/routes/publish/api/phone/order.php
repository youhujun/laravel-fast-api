<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 08:07:53
 * @FilePath: \routes\api\phone\order.php
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
        Route::namespace('Order')->group(function()
        {
            /**
             * 支付订单控制器
             * @see \App\Http\Controllers\Phone\Order\PayOrderController
             */
            Route::controller(PayOrderController::class)->group(function()
            {
                //测试支付订单
                Route::post('testPayOrder','testPayOrder');
            });
        });
   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});
