<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-02-01 09:19:06
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-28 08:01:31
 * @FilePath: d:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\src\App\Providers\PolicyServiceProvider.php
 */

namespace YouHuJun\LaravelFastApi\App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class PolicyServiceProvider extends ServiceProvider
{
	//未发布
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
       \App\Models\Picture\Album::class => \YouHuJun\LaravelFastApi\Policies\Admin\AlbumPolicy::class,
       \App\Models\Picture\AlbumPicture::class => \YouHuJun\LaravelFastApi\Policies\Admin\PicturePlolicy::class
    ]; 

	//已发布
    protected $publishPolicies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Picture\Album::class => \App\Policies\Admin\Picture\AlbumPolicy::class,
        \App\Models\Picture\AlbumPicture::class => \App\Policies\Admin\Picture\PicturePlolicy::class
    ]; 
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Request $request): void
    {
        //注册授权
		$this->registerGate();
		//注册策略
        $this->registerPolicies();
    }

	/**
	 * 注册授权
	 *
	 * @return void
	 */
	public function registerGate()
    {
        $this->registerGatePublish();
    }

	
	/**
	 * 注册策略
	 *
	 * @return void
	 */
	public function registerPolicies()
    {
        if(\config('custom.publish'))
        {
            foreach ($this->publishPolicies as $key => $value) 
            {
                Gate::policy($key, $value);
            } 
        }
        else
        {
            foreach ($this->policies as $key => $value) 
            {
                Gate::policy($key, $value);
            } 
        }
    }

	/**
     * 注册发布角色
     *
     * @return void
     */
    protected function registerGatePublish()
    {
		//如果是开发者或者超级管理员就不验证
		Gate::before(function($admin)
		{
			if($admin->isDevelop())
			{
				return true;
			}

		});  

		//通过角色发布授权
		$this->registerGatePublishByRole();

		//通过策略发布授权
		$this->registerGatePublishByPolicy();

    }

	/**
	 * 通过角色发布授权
	 *
	 * @return void
	 */
	protected function registerGatePublishByRole()
	{
		//后台管理员
		$this->registerAdminGatePublishByRole();
		
		//前台用户
        $this->registerUserGatePublishByRole();
	}

	/**
	 * 后台管理员通过角色发布授权
	 */
	protected function registerAdminGatePublishByRole()
	{
		Gate::define('develop-role',function(?  \App\Models\Admin\Admin $admin)
		{
           return $admin->isDevelop();
        });

        //是否是开发者或者超级管理员
        Gate::define('super-role',function(  \App\Models\Admin\Admin $admin)
		{
           return $admin->isSuper();
        });

        //是否是后台管理员
        Gate::define('admin-role',function( \App\Models\Admin\Admin $admin)
		{
        	return $admin->isAdmin();
        });

		//是否是用户
        Gate::define('user-role',function( \App\Models\Admin\Admin $admin)
		{
        	return $admin->isUser();
        });
	}

	/**
	 * 前台用户通过角色发布授权
	 */
	protected function registerUserGatePublishByRole()
	{
		Gate::define('phone-user-role',function( \App\Models\User\User $user)
		{
        	return $user->isUser();
        });

	}



	/**
	 * 通过策略发布授权
	 *
	 * @return void
	 */
	protected function registerGatePublishByPolicy()
	{
		//注册相册模块授权 
		$this->registerGatePublishAlbum();
		//注册相册图片授权
		$this->registerGatePublishAlbumPicture();
	}

	/**
	 * 注册相册模块授权
	 *
	 * @return void
	 */
	protected function registerGatePublishAlbum()
	{
		//更新相册
		Gate::define('update-album', [\App\Policies\Admin\Picture\AlbumPolicy::class, 'update']);
		//删除相册
		Gate::define('delete-album', [\App\Policies\Admin\Picture\AlbumPolicy::class, 'delete']);
		//查看相册图片
		Gate::define('get-album-picture', [\App\Policies\Admin\Picture\AlbumPolicy::class, 'getAlbumPicture']);
	}

	/**
	 * 注册相册图片授权
	 *
	 * @return void
	 */
	protected function registerGatePublishAlbumPicture()
	{
		//替换上传图片
		Gate::define('reset-picture',[\App\Policies\Admin\Picture\PicturePlolicy::class,'resetUpload']);

		//设置封面
		Gate::define('set-cover',[\App\Policies\Admin\Picture\PicturePlolicy::class,'setCover']);

		//转移相册
		Gate::define('move-album',[\App\Policies\Admin\Picture\PicturePlolicy::class,'moveAlbum']);

		//批量转移相册
		Gate::define('move-multiple-album',[\App\Policies\Admin\Picture\PicturePlolicy::class,'moveMultipleAlbum']);

		//删除图片
		Gate::define('delete-picture',[\App\Policies\Admin\Picture\PicturePlolicy::class,'deletePicture']);

		//批量删除图片
		Gate::define('delete-multiple-picture',[\App\Policies\Admin\Picture\PicturePlolicy::class,'deleteMultiplePicture']);

		//修改图片名称
		Gate::define('update-picture-name',[\App\Policies\Admin\Picture\PicturePlolicy::class,'updatePictureName']);
	}
}
