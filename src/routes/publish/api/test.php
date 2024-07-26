<?php

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
			Route::any('test','test')->withoutMiddleware('phone.login');
		});

   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});

