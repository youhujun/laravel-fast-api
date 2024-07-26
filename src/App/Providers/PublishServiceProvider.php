<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-02-12 10:43:36
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-23 08:58:36
 */

namespace YouHuJun\LaravelFastApi\App\Providers;

use Illuminate\Support\ServiceProvider;

class PublishServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       $this->registerPublish();
    }

    /**
     * 注册发布
     *
     * @return void
     */
    protected function registerPublish()
    {
       if ($this->app->runningInConsole())
       {
		   //发布开发模版
		   //前提是执行了 php artisan 
		   $this->publishStub();

		   //开发初始化发布
		   $this->publishInit();
		   //发布数据填充
		   $this->publishDBSeeders();

		   //发布中间件
		   $this->publishMiddleware();
		  
		   //发布路由
		   $this->publishRoute();

		   //发布自定义验证规则
           $this->publishRules();
		   
		   //发布控制器
           $this->publishController();

		   //发布响应资源
		   $this->publishResource();

		   //发布模型
           $this->publishModels();

		   //发布门面代理
           $this->publishFacade();

		   //发布门面服务
           $this->publishFacadeService();

		   //发布事件
           $this->publishEvent();

		   //发布事件监听
           $this->publishListen();

		   //发布授权策略
           $this->publishPolicy();

		   //发布异常
           $this->publishException();

		   //发布消息通知
           $this->publishNotification();

		   //发布队列任务
           $this->publishJob();

		   //发布模版
		   $this->publishStub();

		   //发布命令
           $this->publishCommand(); 
       }
    }

	/**
	 * 发布替换模版
	 */
	protected function publishStub()
	{
		$this->publishes([
            //发布任务
             __DIR__.'/../../stubs' => base_path('stubs'),
            ],'cover');
		
		//二次安装单独发布
		$this->publishes([
            //发布任务
             __DIR__.'/../../stubs' => base_path('stubs'),
            ],'stub');
	}

    /**
     * 发布初始文件
     *
     * @return void
     */
    protected function publishInit()
    {
		$this->publishes([
			//发布门面,契约和与之对应的服务层
            __DIR__.'/../../laravel-echo-server'=>base_path('laravel-echo-server'),
            __DIR__.'/../../laravel-echo-server.json.example'=>base_path('laravel-echo-server.json.example'),
		],'init');

		//发布计划任务
		$this->publishes([
            __DIR__.'/../../cron/'=>base_path('cron'),
		],'init');

		$this->publishes([
            //发布基础使用文档
            __DIR__.'/../../../Documents/'=>base_path('Documents'),
		],'init');

		//初始开发项目需要发布的
		$this->publishes([
            //发布基础使用文档
            __DIR__.'/../../../.gitignore'=>base_path('.gitignore'),
		],'cover');

		$this->publishes([
			 //发布环境变量模板文件
            __DIR__.'/../../.env.example'=>base_path('.env.example'),

		],'cover');

		$this->publishes([
			 //发布配置文件
            __DIR__.'/../../config/publish/custom'=>config_path('custom'),
            __DIR__.'/../../config/publish/help.php'=>config_path('help.php'),
            __DIR__.'/../../config/publish/image.php'=>config_path('image.php'),
		],'cover');

		$this->publishes([
            //发布基础资源 项目默认图片
            __DIR__.'/../../public/config'=>storage_path('app/public/config'),
            //发布默认的excel模板
            __DIR__.'/../../public/excel'=>storage_path('app/public/excel'),
        ],'cover');

		//二次开发使用用来
		$this->publishes([
            //发布基础资源 项目默认图片
            __DIR__.'/../../public/config'=>storage_path('app/public/config'),
            //发布默认的excel模板
            __DIR__.'/../../public/excel'=>storage_path('app/public/excel'),
        ],'static');
    }

	/**
     * 发布数据填充
     *
     * @return void
     */
    protected function publishDBSeeders()
    {
        //单独发布 数据填充
        $this->publishes([
            __DIR__.'/../../database/publish/seeders'=>database_path('seeders'),
        ],'cover');

    }


	/**
	 * 发布中间件
	 */
	public function publishMiddleware()
	{
		$this->publishes([
        //发布中间件
         __DIR__.'/../Publish/Http/Middleware'=>app_path('Http/Middleware'), 
        ],'init'); 

	}
    

    /**
     * 发布路由
     *
     * @return void
     */
    protected function publishRoute()
    {
        //php artisan vendor:publish --tag=youhujun
        $this->publishes([
        //发布路由文件
        __DIR__.'/../../routes/publish/api'=>base_path('routes/api'),
        
        ],'init'); 

    }


	


    /**
     * 发布自定义请求规则
     *
     * @return void
     */
    protected function publishRules()
    {
        $this->publishes([
            //发布控制器需要的自定义验证规则
            __DIR__.'/../Publish/Rules'=>app_path('Rules'),
        ],'init');
    }

    /**
     * 发布自定义控制器
     *
     * @return void
     */
    protected function publishController()
    {
        $this->publishes([
            //发布控制器
            //测试用
            __DIR__.'/../Publish/Http/Controllers'=>app_path('Http/Controllers'),

        ],'init');

    }

	/**
	 * 发布响应资源api控制
	 *
	 * @return void
	 */
	protected function publishResource()
	{
		  $this->publishes([

			//发布模版
            __DIR__.'/../Publish/Http/Resources'=>app_path('Http/Resources'),
         
		  ],'init');
	}

    /**
     * 发布数据库
     *
     * @return void
     */
    protected function publishModels()
    {
        $this->publishes([
            //模板开发用
             __DIR__.'/../Publish/Models'=>app_path('Models'),
        ],'cover');
    }

        /**
     * 发布门面代理
     *
     * @return void
     */
    protected function publishFacade()
    {
        //发布门面代理
        $this->publishes([
        //开发模板
         __DIR__.'/../Publish/Facade'=>app_path('Facade'),

        ],'init');
    }

    /**
     * 发布代理门面的服务层
     *
     * @return void
     */
    protected function publishFacadeService()
    {
        $this->publishes([
            __DIR__.'/../Publish/Service' => app_path('Service'),
        ],'init');

    }

    /**
     * 发布事件
     *
     * @return void
     */
    protected function publishEvent()
    {
        $this->publishes([
            __DIR__.'/../Publish/Events' => app_path('Events'),
        ],'init');
    }

    /**
     * 发布监听
     *
     * @return void
     */
    protected function publishListen()
    {
        $this->publishes([
            __DIR__.'/../Publish/Listeners' => app_path('Listeners'),
        ],'init');
    }

    /**
     * 发布授权
     *
     * @return void
     */
    protected function publishPolicy()
    {
        $this->publishes([
             __DIR__.'/../Publish/Policies' => app_path('Policies'),
        ],'init');
    }

    /**
     * 发布自定义异常
     *分析 异常需要直接发布到代码中 否则抛出异常需要频繁判断
     * @return void
     */
    protected function publishException()
    {
        $this->publishes([
             __DIR__.'/../Publish/Exceptions' => app_path('Exceptions'),
        ],'init');

    }

    /**
     * 发布通知
     *
     * @return void
     */
    protected function publishNotification()
    {
        $this->publishes([
             __DIR__.'/../Publish/Notifications' => app_path('Notifications'),
        ],'init');
    }

    /**
     * 发布任务与队列
     *
     * @return void
     */
    protected function publishJob()
    {
        $this->publishes([
            //发布任务
             __DIR__.'/../Publish/Jobs' => app_path('Jobs'),
            ],'init');

    }

	/**
	 * 发布命令
	 */
	protected function publishCommand()
	{
		 $this->publishes([
            //发布任务
             __DIR__.'/../Publish/Console' => app_path('Console'),
            ],'cover');
	}

}