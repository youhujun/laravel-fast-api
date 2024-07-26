<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-23 15:35:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 10:26:57
 */

namespace YouHuJun\LaravelFastApi\App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */

     //protected $namespace = 'App\\Http\\Controllers';

     protected $packageNamespace = 'YouHuJun\\LaravelFastApi\\App\\Http\\Controllers';
    
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        if(config('custom.publish'))
        {
            $this->routes(function () 
            {
				//测试路由
				Route::prefix('api')
				->middleware('api')
				->group(\base_path('routes/api/test.php'));
				//**********************************后台路由******************************** */

				//后台路由-登录退出
                Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/admin/login.php')); 
				//开发
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/admin/develop.php')); 
				
				//后台管理-文件上传下载
               Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/admin/file.php')); 
				
			
				//后台路由-系统配置
				 Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/admin/system.php'));  

				//后台路由-用户管理模块
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/admin/user.php')); 

				//后台路由-文章管理模块
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/admin/article.php')); 
				
				//后台路由-图片空间
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/admin/picture.php')); 
				//后台路由-日志管理模块
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/admin/log.php')); 

				
				//**********************************结束******************************** */
				
				//**********************************手机端路由******************************** */

				//手机登录注册
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/phone/login.php')); 

				//文件系统模块
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/phone/file.php'));
				//手机系统
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/phone/system.php'));

				//手机用户(我的)
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/phone/user.php'));

				//订单模块
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/phone/order.php'));

				//回调模块
				Route::prefix('api')
                    ->middleware('api')
                    ->group(\base_path('routes/api/phone/notify.php'));

				
                
              
            });
        }
        else
        {
           /*  $this->routes(function () 
			{

                Route::middleware('web')
                ->group(__DIR__.'/../../routes/web.php');

                Route::middleware('api')
                ->prefix('api')
                ->group(__DIR__.'/../../routes/web.php');
            }); */

        }

    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {

            return Limit::perMinute(60)->response(function(){

                return response()->json(code(\config('common_code.ThrottleError')));

            })->by(optional($request->attributes->get('user'))->id ?: $request->ip());
        });
    }
}
