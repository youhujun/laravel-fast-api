<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-02-13 16:10:12
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-26 17:26:15
 * @FilePath: d:\wwwroot\Working\YouHu\Componenets\Laravel\youhujun\laravel-fast-api\src\App\Providers\LaravelFastApiServiceProvider.php
 */


namespace YouHuJun\LaravelFastApi\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

use App\Models\System\SystemConfig;

class LaravelFastApiServiceProvider extends ServiceProvider
{
    public function register()
    {
       
		$this->mergeConfig();
        //调用合并配置文件

        if(config('custom.publish'))
        {
            $this->addAliasMiddleware('admin.login',\App\Http\Middleware\AdminTokenMiddleware::class);

            $this->addAliasMiddleware('phone.login',\App\Http\Middleware\PhoneTokenMiddleware::class);

        }
        else
        {
			
        }

    }

    public function boot()
    {
        
        Schema::defaultStringLength(255);

        //监听sql
        DB::listen(function(QueryExecuted $query)
        {
			$data = ['sql'=>$query->sql,'param'=>$query->bindings,'time'=>$query->time];
			Log::channel('sql')->debug(['sql'=>$data]);
        });

        //启动自定义命令
        $this->registerCommand();
        //执行运行
        $this->loadRun();

        //运行时动态修改配置文件
        if(config('custom.runing'))
        {
            $this->makeConfig();
        }

		//添加到中间件分组api中 !!!!注意这里只能在这里生效,注册的时候虽然能添加上,但是不生效
		$this->addMiddlewareGroup('api',\App\Http\Middleware\TimeVerifyMiddleware::class);
        
    }

    /**
     * 运行时动态修改配置文件
     *
     * @return void
     */
    protected function makeConfig()
    {     
		
		$systemConfigRedis = Redis::hget('system:config','listSystemConfig');

		if($systemConfigRedis)
		{
			$systemConfigList = unserialize($systemConfigRedis);
		}
		else
		{
			$systemConfigList = SystemConfig::all();
		
			Redis::hset('system:config','listSystemConfig',serialize($systemConfigList));
		}

		if($systemConfigList->count())
		{
			$isSetSystemConfig = Redis::hget('system:config','isSetSystemConfig');

			if(!$isSetSystemConfig)
			{
				foreach ($systemConfigList as $key => $item) 
				{
					$value = [10=>$item->item_label,20=>$item->item_value,30=>$item->item_price,40=>$item->item_path];

					Cache::store('redis')->put($item->item_label,$value[$item->item_type]);
				}

				Redis::hset('system:config','isSetSystemConfig',1);
			}
			
		}	
    }


    /**
     * 自定义配置文件
     *
     * @return void
     */
    protected function mergeConfig()
    {
		
		if(config('help.is_custom'))
		{
			$this->mergeConfigFrom(
            	config_path('custom/custom.php'),'custom'
        	);
		}

		if(config('custom.publish'))
		{
			
			$this->mergeCommonConfig();
			$this->mergeAdminConfig();
			$this->mergePhoneConfig();
		}
		
    }

	/**
	 * 自定义通用配置文件
	 */
	protected function mergeCommonConfig()
	{
		//后台错误码
		$this->mergeConfigFrom(
            config_path('custom/public/code/common_code.php'),'common_code'
        );
		//短信错误码
		$this->mergeConfigFrom(
            config_path('custom/public/code/common_sms_code.php'),'common_code'
        );

		//微信公众号
		$this->mergeConfigFrom(
            config_path('custom/public/code/common_wechat_code.php'),'common_code'
        );

		//地图
		$this->mergeConfigFrom(
            config_path('custom/public/code/common_map_code.php'),'common_code'
        );

		//自定义验证规则错误码
		$this->mergeConfigFrom(
            config_path('custom/public/rule/rule_code.php'),'rule_code'
        );
	}

	/**
	 * 自定义后台配置文件
	 */
	protected function mergeAdminConfig()
	{
		//后台错误码
		//整合
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_code.php'),'admin_code'
        );
		//系统配置
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_system_code.php'),'admin_code'
        );
		//文章
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_article_code.php'),'admin_code'
        );
		//文件
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_file_code.php'),'admin_code'
        );
		//产品
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_goods_code.php'),'admin_code'
        );
		//日志
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_log_code.php'),'admin_code'
        );
		//登录
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_login_code.php'),'admin_code'
        );
		//订单
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_order_code.php'),'admin_code'
        );
		//其他
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_other_code.php'),'admin_code'
        );
		//图片空间
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_picture_code.php'),'admin_code'
        );
		//用户
		$this->mergeConfigFrom(
            config_path('custom/admin/code/admin_user_code.php'),'admin_code'
        );

		//后台事件码
		//全部
		$this->mergeConfigFrom(
            config_path('custom/admin/event/admin_event.php'),'admin_event'
        );
		//文章
		$this->mergeConfigFrom(
            config_path('custom/admin/event/admin_article_event.php'),'admin_event'
        );
		//文件
		$this->mergeConfigFrom(
            config_path('custom/admin/event/admin_file_event.php'),'admin_event'
        );
		//产品
		$this->mergeConfigFrom(
            config_path('custom/admin/event/admin_goods_event.php'),'admin_event'
        );
		//订单
		$this->mergeConfigFrom(
            config_path('custom/admin/event/admin_order_event.php'),'admin_event'
        );
		//图片空间
		$this->mergeConfigFrom(
            config_path('custom/admin/event/admin_picture_event.php'),'admin_event'
        );
		//系统
		$this->mergeConfigFrom(
            config_path('custom/admin/event/admin_system_event.php'),'admin_event'
        );
		//用户
		$this->mergeConfigFrom(
            config_path('custom/admin/event/admin_user_event.php'),'admin_event'
        );
	}

	/**
	 * 自定义手机配置文件
	 */
	protected function mergePhoneConfig()
	{
		//手机错误码
		$this->mergeConfigFrom(
            config_path('custom/phone/code/phone_code.php'),'phone_code'
        );
		//登录注册
		$this->mergeConfigFrom(
            config_path('custom/phone/code/phone_login_code.php'),'phone_code'
        );
		//文件
		$this->mergeConfigFrom(
            config_path('custom/phone/code/phone_file_code.php'),'phone_code'
        );
		//支付
		$this->mergeConfigFrom(
            config_path('custom/phone/code/phone_pay_code.php'),'phone_code'
        );
		//手机用户
		$this->mergeConfigFrom(
            config_path('custom/phone/code/phone_user_code.php'),'phone_code'
        );

		//手机事件码
		$this->mergeConfigFrom(
            config_path('custom/phone/event/phone_event.php'),'phone_event'
        );
		//文件
		$this->mergeConfigFrom(
            config_path('custom/phone/event/phone_file_event.php'),'phone_event'
        );
		//用户
		$this->mergeConfigFrom(
            config_path('custom/phone/event/phone_user_event.php'),'phone_event'
        );
	}



    /**
     * 自定义运行
     *
     * @return void
     */
    protected function loadRun()
    {
         //运行数据库迁移
         $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

		 //系统模块
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/System');
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/System/Union');

		  //系统--银行
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/System/Bank');
		 //系统--分类管理--标签
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/System/Label');
		 //系统--级别管理
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/System/Level');
		 //系统-权限
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/System/Permission');
		 //系统-地区
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/System/Region');
		 //系统-角色
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/System/Role');
		
		 //用户模块
         $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/User');
         $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/User/Log');
         $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/User/Union');
		 //用户管理--管理员管理
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/Admin');
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/Admin/Log');
		 
		 //文章管理
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/Article');
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/Article/Union');

		 //产品模块
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/Goods');
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/Goods/Union');

		 //图片空间
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/Picture');
		 //任务
		 $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/Job');
    }

    /**
     * @param string $name
     * @param string $class
     * @return void
     */
    protected function addAliasMiddleware(string $name,string $class)
    {
         $router = $this->app['router'];
         //执行完相当于在app/Http/Kernel.php中注册了中间件
		 $router = $router->aliasMiddleware($name, $class);
         return $router;
    }

    /**
     * @param string $group
     * @param string $class
     * @return void
     */
    protected function addMiddlewareGroup(string $group, string $class)
    {
        $router = $this->app['router'];

		$router = $router->pushMiddlewareToGroup($group, $class);

		//dd($result);
        //执行完相当于在app/Http/Kernel.php中注册了中间件
        return $router;
    }



       /**
     * @description: 注册自定义命令
     * @param {type} 
     * @return: 
     */
    protected function registerCommand()
    {
        if($this->app->runningInConsole())
        {
            $this->commands([
                \YouHuJun\LaravelFastApi\App\Console\Commands\BuildFacadeCommand::class,
                \YouHuJun\LaravelFastApi\App\Console\Commands\BuildFacadeServiceCommand::class,
                \YouHuJun\LaravelFastApi\App\Console\Commands\CallFacadeServiceCommand::class,
            ]);
        }
    }
}
