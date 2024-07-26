<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 14:48:44
 * @FilePath: \routes\api\phone\system.php
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
        Route::namespace('System')->group(function()
        {
            /**
             * 支付订单控制器
             * @see \App\Http\Controllers\Phone\System\MapController
             */
            Route::controller(MapController::class)->group(function()
            {
                //通过经纬度获取
                Route::post('getLocationRegionByH5','getLocationRegionByH5');
            });
        });
   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});
