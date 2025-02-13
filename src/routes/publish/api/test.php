<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-25 09:47:12
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-28 21:47:13
 * @FilePath: \routes\api\test.php
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
		* @see App\Http\Controllers\TestController
		*/
		 Route::controller(TestController::class)->group(function()
		{
			//后台测试接口
			Route::any('test','test')->withoutMiddleware('admin.login');
			//Route::any('test','test');

		});

   });

   Route::group([],function()
   {
        /**
		* bind
		* @see App\Http\Controllers\TestController
		*/
		 Route::controller(TestController::class)->group(function()
		{
			 //测试事件
             Route::any('testEvent','testEvent')->withoutMiddleware('admin.login');

			 //测试后台主动发送消息,手机端接口消息
			 Route::any('testWebsocket','testWebsocket')->withoutMiddleware('admin.login');
		});

   });
});

/**
 * 后端模版
 */
Route::prefix(config('custom.version'))->namespace($namespace)->middleware('phone.login')->group(function()
{
    Route::prefix('phone')->group(function()
    {

		/**
		* bind
		* @see App\Http\Controllers\TestController
		*/
		Route::controller(TestController::class)->group(function()
		{
			//手机测试接口
			Route::any('test','phoneTest')->withoutMiddleware('phone.login');
		});

   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});

