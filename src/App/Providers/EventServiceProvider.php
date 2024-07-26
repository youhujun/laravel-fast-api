<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-30 23:14:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-16 10:34:25
 */

namespace YouHuJun\LaravelFastApi\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
   
    protected $listener = [
        //=====================后台=======================
        
		 //======================手机======================
    ];

    protected $subscribe = [
      //=====================后台=======================
     
	 //======================手机======================

    ];

	//后台
	protected $publishAdminListener;
	//手机
	protected $publishPhoneListener;

	//通用
    protected $publishListener = [

    ];

    protected $publishSubscribe = [

    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if(config('custom.publish'))
        {

			//先设置
			//后台发布
			$this->setAdminPublish();
			//手机发布
			$this->setPhonePublish();

            $this->runPublish();

			//后台发布
			$this->runAdminPubish();
			//手机发布
			$this->runPhonePublish();
        }
        else
        {
            $this->run();
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * 组件包运行
     *
     * @return void
     */
    protected function run()
    {
        $events = $this->listener;

        foreach ($events as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            Event::subscribe($subscriber);
        }
    }

    /**
     * 发布后的项目运行
     *
     * @return void
     */
    protected function runPublish()
    {
        $events = $this->publishListener;

        foreach ($events as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($this->publishSubscribe as $subscriber) {
            Event::subscribe($subscriber);
        }
    }

	/**
	 * 注册后台监听事件
	 */
	protected function runAdminPubish()
	{
		$events = $this->publishAdminListener;

        foreach ($events as $event => $listeners) 
		{
            foreach (array_unique($listeners) as $listener) 
			{
                Event::listen($event, $listener);
            }
        }
	}

	/**
	 * 注册手机监听事件
	 */
	protected function runPhonePublish()
	{
		$events = $this->publishPhoneListener;

        foreach ($events as $event => $listeners) 
		{
            foreach (array_unique($listeners) as $listener) 
			{
                Event::listen($event, $listener);
            }
        }
	}



	/**
	 * 设置后台发布
	 */
	protected function setAdminPublish()
	{
		//后台管理-用户事件
		$publishAdminUserListener = [
			//|--|--管理员管理
			//添加管理员
			\App\Events\Admin\User\Admin\AddAdministratorEvent::class=>[
				//添加管理员相册
				\App\Listeners\Admin\User\Admin\AddAdministratorEvent\AddAdministratorAlbumListener::class,
				//添加管理员角色
				\App\Listeners\Admin\User\Admin\AddAdministratorEvent\AddAdministratorRoleListener::class
			],
			//更新管理员
			\App\Events\Admin\User\Admin\UpdateAdministratorEvent::class=>[
				\App\Listeners\Admin\User\Admin\UpdateAdministratorEvent\UpdateAdministratorRoleListener::class
			],
			//用户管理
			//添加用户
			\App\Events\Admin\User\User\AddUserEvent::class =>[
				\App\Listeners\Admin\User\User\AddUserEvent\AddUserAlbumListener::class,
				\App\Listeners\Admin\User\User\AddUserEvent\AddUserAvatarListener::class,
				\App\Listeners\Admin\User\User\AddUserEvent\AddUserInfoListener::class,
				\App\Listeners\Admin\User\User\AddUserEvent\AddUserRoleListener::class,
				\App\Listeners\Admin\User\User\AddUserEvent\AddUserAddressListener::class,
				\App\Listeners\Admin\User\User\AddUserEvent\AddUserQrcodeListener::class
			],

			//后台设置用户身份证
			\App\Events\Admin\User\User\SetUserIdCardEvent::class => [
				//添加用户实名认证申请
				\App\Listeners\Admin\User\User\SetUserIdCardEvent\AddUserRealAuthApplyListener::class
			],
			
			//后台审核实名认证用户
			\App\Events\Admin\User\User\CheckUserRealAuthEvent::class => [
				//更新用户实名认证申请状态
				\App\Listeners\Admin\User\User\CheckUserRealAuthEvent\UpdateUserRealAuthApplyListener::class
			],

			//后台设置用户账户
			\App\Events\Admin\User\User\SetUserAccountEvent::class => [
				\App\Listeners\Admin\User\User\SetUserAccountEvent\AddUserAccountLogListener::class
			]
		];

		//后台管理-文航管理
		$publisAdminArticleListener = [
			//|--文章管理
			//添加文章
			\App\Events\Admin\Article\AddArticleEvent::class => [
				\App\Listeners\Admin\Article\AddArticleEvent\AddArticleInfoListener::class,
				\App\Listeners\Admin\Article\AddArticleEvent\AddArticleCategoryUnionListener::class,
				\App\Listeners\Admin\Article\AddArticleEvent\AddArticleLabelUnionListener::class
			],
			//更新文章
			\App\Events\Admin\Article\UpdateArticleEvent::class => [
				\App\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleInfoListener::class,
				\App\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleCategoryUnionListener::class,
				\App\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleLabelUnionListener::class
			],
		];

		//后台事件监听
		$publishAdminSystemListener = [
			//管理员登录 
			\App\Events\Admin\Login\AdminLoginEvent::class =>[
				\App\Listeners\Admin\Login\AdminLoginEvent\AdminLoginLogListener::class,
				\App\Listeners\Admin\Login\AdminLoginEvent\CacheAdminRolesListener::class,
			],
			//管理员退出
			\App\Events\Admin\Login\AdminLogoutEvent::class=>[
				\App\Listeners\Admin\Login\AdminLogoutEvent\AdminLogoutLogLitener::class,
				\App\Listeners\Admin\Login\AdminLogoutEvent\ClearAdminCacheListener::class
			],
			//公共事件日志
			\App\Events\Admin\CommonEvent::class => [
			\App\Listeners\Admin\CommonEvent\CommonEventListener::class
			], 
			//添加开发者
			\App\Events\Admin\Develop\AddDeveloperEvent::class =>[
				//后台管理员
				\App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperAdminListener::class,
				//用户相册
				\App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperAdminAlbumListener::class,
				//用户地址
				\App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserAddressListener::class,
				//用户头像
				\App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserAvatarListener::class,
				//用户详情
				\App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserinfoListener::class,
				//用户二维码
				\App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserQrcodeListener::class,
				//用户角色
				\App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserRoleListener::class,
			],
			//|--后台系统
			//|--|--上传文件
			\App\Events\Admin\File\UploadFileEvent::class => [
				\App\Listeners\Admin\File\UploadFileEvent\UploadFileLogListener::class,
				\App\Listeners\Admin\File\UploadFileEvent\UploadFileImportListener::class
			],
		];

		$this->publishAdminListener = array_merge($publishAdminSystemListener,$publishAdminUserListener,$publisAdminArticleListener);
	}

	/**
	 * 设置手机发布
	 */
	protected function setPhonePublish()
	{
		//手机用户
		$publishPhoneUserListener = [
			//用户申请实名认证
			\App\Events\Phone\User\UserApplyRealAuthEvent::class => [
				//更新用户实名认证申请状态
				\App\Listeners\Phone\User\UserApplyRealAuthEvent\UpdateUserRealAuthStatusListener::class,
				//更新用户信息
				\App\Listeners\Phone\User\UserApplyRealAuthEvent\UpdateUserInfoListener::class,
				//添加用户身份证
				\App\Listeners\Phone\User\UserApplyRealAuthEvent\AddUserIdCardListener::class,
			],
		];

		//手机登录注册
		$publishLoginListener = [
			//手机登录
			\App\Events\Phone\User\UserLoginEvent::class=>[
				//添加手机登录日志
				\App\Listeners\Phone\User\UserLoginEvent\AddPhoneUserLogListener::class
			],

			//手机退出
			\App\Events\Phone\User\UserLogoutEvent::class => [
				//添加手机退出日志
				\App\Listeners\Phone\User\UserLogoutEvent\AddPhoneUserLogListener::class,
				//清除用户缓存
				\App\Listeners\Phone\User\UserLogoutEvent\ClearPhoneUserCacheListener::class,
			],

			//用户注册
			\App\Events\Phone\User\UserRegisterEvent::class =>[
				//用户详情 
				\App\Listeners\Phone\User\UserRegisterEvent\AddUserInfoListener::class,
				//用户相册
				\App\Listeners\Phone\User\UserRegisterEvent\AddUserAlbumListener::class,
				//用户头像
				\App\Listeners\Phone\User\UserRegisterEvent\AddUserAvatarListener::class,
				//用户角色
				\App\Listeners\Phone\User\UserRegisterEvent\AddUserRoleListener::class,
				//用户二维码
				\App\Listeners\Phone\User\UserRegisterEvent\AddUserQrcodeListener::class,
				//用户推荐人
				\App\Listeners\Phone\User\UserRegisterEvent\AddUserSourceListener::class,

			],

			//微信公众号登录注册
			\App\Events\Phone\User\Wechat\WechatOfficialRegisterEvent::class => [
				//用户详情
				\App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserInfoListener::class,
				//用户相册
				\App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserAlbumListener::class,
				//用户头像
				\App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserAvatarListener::class,
				//用户角色
				\App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserRoleListener::class,
				//用户二维码
				\App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserQrcodeListener::class
			],

			//用户微信绑定openid
			\App\Events\Phone\User\Wechat\WechatOfficialBindUserOpenidEvent::class=>[
				//绑定用户的openid
				\App\Listeners\Phone\User\Wechat\WechatOfficialBindUserOpenidEvent\WechatOfficialBindUserOpenidListener::class
			],
		];

		//系统事件
		$publishPhoneSystemListener = [
			\App\Events\Phone\CommonEvent::class =>[
				\App\Listeners\Phone\CommonEvent\CommonEventListener::class
			],
		];

		$this->publishPhoneListener = array_merge($publishPhoneUserListener,$publishLoginListener,$publishPhoneSystemListener);
	}
}
