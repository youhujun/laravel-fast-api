<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-30 23:14:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 03:13:48
 */

namespace YouHuJun\LaravelFastApi\App\Providers;

use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if(\config('custom.publish'))
        {
			//公共第三方门面
            $this->publishPublicFacade();
			//后台门面
			$this->publishAdminFacade();
			//手机门面
			$this->publishPhoneFacade();
			//通用公共门面
			$this->publishCommonFacade();
        }
        else
        {
           
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

	/**
	 * 通用公共门面
	 */
	protected function publishCommonFacade()
	{
		//公共统计
		$this->app->singleton('TotalAllDataFacade',\App\Service\Facade\Common\Total\TotalAllDataFacadeService::class);
	}
	/**
	 * 公共的门面 第三方跟业务无关
	 */
	protected function publishPublicFacade()
	{
		//excel
		$this->app->singleton('PublicExcelFacade',\App\Service\Facade\Public\Excel\PublicExcelFacadeService::class);

		//二维码
		$this->app->singleton('PublicQrcodeFacade',\App\Service\Facade\Public\Qrcode\PublicQrcodeFacadeService::class);

		//短信
		$this->app->singleton('SmsFacade',\App\Service\Facade\Public\Sms\SmsFacadeService::class);
		//腾讯云短信 
		$this->app->singleton('TencentSmsFacade',\App\Service\Facade\Public\Sms\TencentSmsFacadeService::class);

		//微信公众号
		$this->app->singleton('WechatOfficialFacade',\App\Service\Facade\Public\Wechat\WechatOfficialFacadeService::class);

		//七牛云
		$this->app->singleton('QiNiuFacade',\App\Service\Facade\Public\Store\QiNiuFacadeService::class);

		//公共门面-支付管理
		$this->publishPublicPayFacade();

		//公共门面-地图位置
		$this->publishPublicMapFacade();


	}

	/**
	 * 公共门面-支付管理
	 */
	protected function publishPublicPayFacade()
	{
		//微信H5的js支付
		$this->app->singleton('WechatJsPayFacade',\App\Service\Facade\Public\Wechat\Pay\WechatJsPayFacadeService::class);

		//微信H5支付回调解密
		$this->app->singleton('WechatJsPayDecryptFacade',\App\Service\Facade\Public\Wechat\Pay\WechatJsPayDecryptFacadeService::class);

	}

	/**
	 * 公共门面-地图位置
	 */
	protected function publishPublicMapFacade()
	{
		//地图位置
		$this->app->singleton('TencentMapFacade',\App\Service\Facade\Public\Map\TencentMapFacadeService::class);
	}

	/**
	 * 绑定发布的后台门面
	 */
	protected function publishAdminFacade()
	{
		//后台登录管理门面
		$this->app->singleton('AdminLoginFacade',\App\Service\Facade\Admin\Login\AdminLoginFacadeService::class);

		//后台路由权限
		$this->app->singleton('AdminPermissionFacade',\App\Service\Facade\Admin\System\Permission\AdminPermissionFacadeService::class);

		//后台开发者
		$this->app->singleton('DeveloperFacade',\App\Service\Facade\Admin\Develop\DeveloperFacadeService::class);

		//|--后台管理
		//|--|--文件处理
		//|--|--|--|文件上传
		$this->app->singleton('AdminUploadFacade',\App\Service\Facade\Admin\File\AdminUploadFacadeService::class);

		//文章
        $this->app->singleton('AdminArticleFacade',\App\Service\Facade\Admin\Article\AdminArticleFacadeService::class);

		//后台管理-系统设置
		$this->publishAdminSystemFacade();
		//后台管理-用户管理
		$this->publishAdminUserFacade();
		//后台管理-图片空间
		$this->publishAdminPictureFacade();
		//后台管理-日志管理
		$this->publishAdminLogFacade();
		
	}

	/**
	 * 发布后台管理系统设置门面
	 */
	protected function publishAdminSystemFacade()
	{
		//|--|--系统设置
		//|--|--|--系统配置
		//|--|--|--|--参数配置
		$this->app->singleton('AdminSystemConfigFacade',\App\Service\Facade\Admin\System\SystemConfig\AdminSystemConfigFacadeService::class);
		//|--|--|--|--提示配置
		$this->app->singleton('AdminVoiceConfigFacade',\App\Service\Facade\Admin\System\SystemConfig\AdminVoiceConfigFacadeService::class);
		//|--|--|--平台配置
		//|--|--|--|--缓存设置
		$this->app->singleton('AdminCacheConfigFacade',\App\Service\Facade\Admin\System\Platform\AdminCacheConfigFacadeService::class);
		
		//|--|--|--|--首页轮播
		$this->app->singleton('AdminPhoneBannerFacade',\App\Service\Facade\Admin\System\Platform\AdminPhoneBannerFacadeService::class);
		//|--|--|--|--|--轮播图详情
		$this->app->singleton('AdminPhoneBannerDetailsFacade',\App\Service\Facade\Admin\System\Platform\PhoneBanner\AdminPhoneBannerDetailsFacadeService::class);

		//|--|--|--|--角色管理
        $this->app->singleton('AdminRoleFacade',\App\Service\Facade\Admin\System\Role\AdminRoleFacadeService::class);

		//|--|--|--|--分类管理
		 //|--|--|--|--|产品分类
        $this->app->singleton('AdminGoodsClassFacade',\App\Service\Facade\Admin\System\Group\AdminGoodsClassFacadeService::class);
        //|--|--|--|--|文章分类
        $this->app->singleton('AdminCategoryFacade',\App\Service\Facade\Admin\System\Group\AdminCategoryFacadeService::class);
        //|--|--|--|--|标签管理
        $this->app->singleton('AdminLabelFacade',\App\Service\Facade\Admin\System\Group\AdminLabelFacadeService::class);
		
		//|--|--|--|--级别管理
		//|--|--|--|--|--级别条件
        $this->app->singleton('AdminLevelItemFacade',\App\Service\Facade\Admin\System\Level\AdminLevelItemFacadeService::class);
		//|--|--|--|--|--用户级别
        $this->app->singleton('AdminUserLevelFacade',\App\Service\Facade\Admin\System\Level\AdminUserLevelFacadeService::class);
		//|--|--|--|--地区管理
        $this->app->singleton('AdminRegionFacade',\App\Service\Facade\Admin\System\Region\AdminRegionFacadeService::class);
        //|--|--|--|--银行管理
        $this->app->singleton('AdminBankFacade',\App\Service\Facade\Admin\System\Bank\AdminBankFacadeService::class);
	}

	/**
	 * 发布后台管理用户管理门面
	 */
	protected function publishAdminUserFacade()
	{
		//|--|--用户管理
			//|--|--|--管理员管理
        	$this->app->singleton('AdministratorFacade',\App\Service\Facade\Admin\User\Admin\AdministratorFacadeService::class);
			//|--|--|--用户管理
			$this->app->singleton('AdminUserFacade',\App\Service\Facade\Admin\User\User\AdminUserFacadeService::class);
			//|--|--|--|++用户选项
			$this->app->singleton('AdminUserItemFacade',\App\Service\Facade\Admin\User\User\AdminUserItemFacadeService::class);

			//|--|--|--|++用户详情
			$this->app->singleton('AdminUserDetailsFacade',\App\Service\Facade\Admin\User\User\AdminUserDetailsFacadeService::class);
			//|--|--|--|++用户地址
			$this->app->singleton('AdminUserAddressFacade',\App\Service\Facade\Admin\User\User\AdminUserAddressFacadeService::class);
			//|--|--|--|++用户银行卡
			$this->app->singleton('AdminUserBankFacade',\App\Service\Facade\Admin\User\User\AdminUserBankFacadeService::class);
			//|--|--|--|++用户团队
			$this->app->singleton('AdminUserTeamFacade',\App\Service\Facade\Admin\User\User\AdminUserTeamFacadeService::class);
			//|--|--|--|++用户账户
			$this->app->singleton('AdminUserAccountFacade',\App\Service\Facade\Admin\User\User\AdminUserAccountFacadeService::class);
			//|--|--|--|++用户实名认证
        	$this->app->singleton('AdminUserRealAuthFacade',\App\Service\Facade\Admin\User\User\AdminUserRealAuthFacadeService::class);
	}


	/**
	 * 发布后台管理图片空间门面
	 */
    protected function publishAdminPictureFacade()
	{
		//|--|--图片空间
		//|--|--|--我的相册
		$this->app->singleton('AdminAlbumFacade',\App\Service\Facade\Admin\Picture\AdminAlbumFacadeService::class);
			
		//|--|--|--|--图片处理
		$this->app->singleton('AdminPictureFacade',\App\Service\Facade\Admin\Picture\AdminPictureFacadeService::class);
	}

	/**
	 * 发后台管理日志门面
	 */
	protected function publishAdminLogFacade()
	{
		//后台管理
		//后台管理-日志管理
		//后台管理-日志管理-后台日志
        $this->app->singleton('AdminLogFacade',\App\Service\Facade\Admin\Log\AdminLogFacadeService::class);
		//后台管理-日志管理-用户日志
        $this->app->singleton('AdminUserLogFacade',\App\Service\Facade\Admin\Log\AdminUserLogFacadeService::class);

		
	}


	/**
	 * 绑定手机端发布的门面
	 */
	protected function publishPhoneFacade()
	{

		//手机端登录
		$this->app->singleton('PhoneLoginFacade',\App\Service\Facade\Phone\Login\PhoneLoginFacadeService::class);
		
		//手机端注册
		$this->app->singleton('PhoneRegisterFacade',\App\Service\Facade\Phone\Login\PhoneRegisterFacadeService::class);

		//手机用户Source门面
		$this->app->singleton('PhoneUserSourceFacade',\App\Service\Facade\Phone\User\PhoneUserSourceFacadeService::class);

		//手机端-websocket
		$this->publishPhoneSocketFacade();
		//手机端-系统门面
		$this->publishPhoneSystemFacade();
		//手机端-文件管理
		$this->publishPhoneFileFacade();
		//手机端-支付管理
		$this->publishPhonePayFacade();
		//手机端-用户管理
		$this->publishPhoneUserFacade();

		
	}

	/**
	 * 手机端-websocket门面
	 */
	protected function publishPhoneSocketFacade()
	{
		//手机端websocket门面
		$this->app->singleton('PhoneSocketFacade', \App\Service\Facade\Phone\Websocket\PhoneSocketFacadeService::class);

		//手机端-websocket-用户门面
		$this->app->singleton('PhoneSocketUserFacade', \App\Service\Facade\Phone\Websocket\User\PhoneSocketUserFacadeService::class);
	}

	/**
	 * 手机端-系统门面
	 */
	protected function publishPhoneSystemFacade()
	{
		//手机地图门面
		$this->app->singleton('PhoneMapFacade',\App\Service\Facade\Phone\System\PhoneMapFacadeService::class);
	}

	/**
	 * 手机端-文件管理
	 */
	protected function publishPhoneFileFacade()
	{
		//手机端-图片处理
		$this->app->singleton('PhonePictureFacade',\App\Service\Facade\Phone\File\PhonePictureFacadeService::class);
	}

	/**
	 * 手机端-支付管理
	 */
	protected function publishPhonePayFacade()
	{
		//手机端-支付管理
		$this->app->singleton('PhonePayFacade',\App\Service\Facade\Phone\Pay\PhonePayFacadeService::class);

		//手机端-支付管理-微信支付
		$this->app->singleton('WechatPayFacade',\App\Service\Facade\Phone\Pay\WechatPayFacadeService::class);

		//手机端-支付回调
		$this->app->singleton('PhonePayNotifyFacade',\App\Service\Facade\Phone\Notify\PhonePayNotifyFacadeService::class);
	}

	/**
	 * 手机端-用户管理
	 */
	protected function publishPhoneUserFacade()
	{
		//手机端-用户门面
		$this->app->singleton('PhoneUserFacade',\App\Service\Facade\Phone\User\User\PhoneUserFacadeService::class);
		//手机端-用户配置门面
		$this->app->singleton('PhoneUserConfigFacade',\App\Service\Facade\Phone\User\User\PhoneUserConfigFacadeService::class);
	}
	
    /**
     * 绑定发布的门面代理
     *
     * @return void
     */
    public function publishFacade()
    {
		 //模板替换
        $this->app->singleton('Replace',\App\Service\Facade\ReplaceService::class);
    }


    /**
     * 绑定未发布的门面代理
     *
     * @return void
     */
    public function unPublishFacade()
    {
       
    }


}