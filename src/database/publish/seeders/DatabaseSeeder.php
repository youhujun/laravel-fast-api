<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-23 15:35:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 09:15:33
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//---------------系统设置开始-----------------
//|--系统设置
//|--|--系统配置
//空模版
use Database\Seeders\System\SystemConfig\SystemConfigSeeder;
//后台提示音配置
use Database\Seeders\System\SystemConfig\VoiceConfigSeeder;

//|--|--菜单路由
use Database\Seeders\System\PermissionSeeder;
//|--|--角色管理
use Database\Seeders\System\RoleSeeder;
//|--|--|++建立角色和菜单权限
use Database\Seeders\System\RolePermissionSeeder;
//|--|--分类管理
//|--|--|--产品分类
//|--|--|--文章分类
use Database\Seeders\System\Group\Category\CategorySeeder;
//|--|--级别管理
//|--|--|--|级别配置项
use Database\Seeders\System\Level\LevelItemSeeder;
//|--|--|--|级别管理
use Database\Seeders\System\Level\LevelSeeder;
//|--|--|--|++建立级别和级别的关系
use Database\Seeders\System\Level\LevelItemUnionSeeder;
//|--|--地区管理
use Database\Seeders\System\RegionSeeder;
//|--|--银行管理
use Database\Seeders\System\BankSeeder;

//---------------系统设置结束-----------------


//|--图片空间
//|--|--我的相册
use Database\Seeders\Picture\AlbumSeeder;
//|--|--|++相册图片
use Database\Seeders\Picture\AlbumPictureSeeder;

//------------------用户管理开始-----------------
//|--用户管理
//|--|--用户管理
use Database\Seeders\User\UserSeeder;
//|--|--|++用户角色处理
use Database\Seeders\User\UserRoleUnionSeeder;

//|--|--|++用户详情
use Database\Seeders\User\UserInfoSeeder;
//|--|--管理员管理
use Database\Seeders\User\AdminSeeder;

//------------------用户管理结束-----------------

class DatabaseSeeder extends Seeder
{
    //系统配置定义
    protected $systemConfig = [
        'Laravel'=> SystemConfigSeeder::class
    ];

    //文章分类管理定义
    protected $category = [
        'Laravel'=> CategorySeeder::class,
    ];
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $appName = '';
       //$appName = config('custom.app_name');

       if(!$appName)
       {
            $appName = 'Laravel';
       }
       //|--系统设置
       $this->call([
             //|--|--系统配置-参数配置
            $this->systemConfig[$appName],
			////|--|--系统配置-提示配置
			VoiceConfigSeeder::class,
            //|--|--菜单管理
            PermissionSeeder::class,
            //|--|--角色管理
            RoleSeeder::class,
            //|--|--|++绑定角色和菜单的关系
            RolePermissionSeeder::class,
            //|--|--|--|--文章分类
            $this->category[$appName],
            //|--|--级别管理
            //|--|--|--|级别配置项
            LevelItemSeeder::class,
            //|--|--|--|级别管理
            LevelSeeder::class,
            //|--|--|--|++建立级别和级别的关系
            LevelItemUnionSeeder::class,
            //|--|--地区管理
            RegionSeeder::class,
            //|--|--银行管理
            BankSeeder::class,
       ]);

       //|--图片空间
       $this->call([
            //|--|--我的相册
            AlbumSeeder::class,
            //|--|--|++相册图片
            AlbumPictureSeeder::class,
       ]);

       //|--用户管理
       $this->call(
        [
           //|--|--用户管理
           UserSeeder::class,
           //|--|--|++绑定用户管理和角色的关系
           UserRoleUnionSeeder::class,
           //|--|--|++用户详情
           UserInfoSeeder::class,
           //|--|--管理员管理
           AdminSeeder::class,

        ]);
    }
}
