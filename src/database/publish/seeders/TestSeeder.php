<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-07-24 14:49:06
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-06 23:10:32
 * @FilePath: \api.laravel.com_LV9\database\seeders\TestSeeder.php
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
//游鹄
use Database\Seeders\System\SystemConfig\SystemConfigYouhuSeeder;
//小丁
use Database\Seeders\System\SystemConfig\SystemConfigXiaodingSeeder;
//纽森
use Database\Seeders\System\SystemConfig\SystemConfigNiusenSeeder;
//|--|--菜单路由
use Database\Seeders\System\PermissionSeeder;
//|--|--角色管理
use Database\Seeders\System\RoleSeeder;
//|--|--|++建立角色和菜单权限
use Database\Seeders\System\RolePermissionSeeder;
//|--|--分类管理
//|--|--|--产品分类
use Database\Seeders\System\Group\Classification\ClassificationXiaoDingSeeder;
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

//-----------------业务设置开始-----------------
//|--业务设置
//|--|--通用设置
//|--|--|--集合设置
use Database\Seeders\Business\BusinessSystemConfigSeeder;
//|--|--|--退款设置
use Database\Seeders\Business\BusinessRefundConfigSeeder;
//|--|--|--显示权限
//|--|--|--|++显示权限配置
use Database\Seeders\Business\BusinessShowConfigSeeder;
//|--|--|--|++显示权限关联地区
use Database\Seeders\Business\BusinessShowRegionUnionSeeder;
//|--|--|--店铺类型
use Database\Seeders\Business\ShopTypeSeeder;
//|--|--营销分润
use Database\Seeders\Business\DistributionSeeder;
//|--|--充值设置
use Database\Seeders\Business\RechargeConfigSeeder;
//|--|--行程费用
use Database\Seeders\Business\ExpenseConfigSeeder;
//|--|--评论设置
use Database\Seeders\Business\CommentSeeder;

//---------------业务设置结束-----------------

//++++++++++++++++系统内部设置+++++++++++++++
//分销控制
use Database\Seeders\Config\ParamConfigSeeder;

//++++++++++++++++系统内部设置结束+++++++++++++++

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
use Database\Seeders\User\SystemFatherSeeder;
use Database\Seeders\User\UserFatherSeeder;
//|--|--|++用户详情
use Database\Seeders\User\UserInfoSeeder;
//|--|--管理员管理
use Database\Seeders\User\AdminSeeder;

//------------------用户管理结束-----------------


class TestSeeder extends Seeder
{
    //系统配置定义
    protected $systemConfig = [
        'Laravel'=> SystemConfigSeeder::class,
        'YouHu'=> SystemConfigYouhuSeeder::class,
        'XiaoDing'=> SystemConfigXiaodingSeeder::class,
        'NiuSen'=> SystemConfigNiusenSeeder::class,
    ];
    //产品分类管理定义
    protected $classification = [
        'Laravel'=> ClassificationXiaoDingSeeder::class,
        'YouHu'=> ClassificationXiaoDingSeeder::class,
        'XiaoDing'=> ClassificationXiaoDingSeeder::class,
        'NiuSen'=> ClassificationXiaoDingSeeder::class,
    ];
    //文章分类管理定义
    protected $category = [
        'Laravel'=> CategorySeeder::class,
        'YouHu'=> CategorySeeder::class,
        'XiaoDing'=> CategorySeeder::class,
        'NiuSen'=> CategorySeeder::class,
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //测试权限菜单
        $appName = config('custom.app_name');
        //系统设置
        $this->call([

       ]);
    }
}
