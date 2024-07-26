<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-22 14:35:41
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 09:33:24
 * @FilePath: \database\seeders\System\PermissionSeeder.php
 */


//后台带单管理
namespace Database\Seeders\System;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //一级类目
        $oneDeepData = [
            //|--1
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/config','component'=>'Layout','name'=>'config','meta_title'=>'系统设置','meta_icon'=>'el-icon-s-tools','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--2
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/businesses','component'=>'Layout','name'=>'businesses','meta_title'=>'业务设置','meta_icon'=>'example','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--3
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/users','component'=>'Layout','name'=>'users','meta_title'=>'用户管理','meta_icon'=>'peoples','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--4
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/goods','component'=>'Layout','name'=>'goods','meta_title'=>'产品管理','meta_icon'=>'el-icon-s-goods','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--5
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/order','component'=>'Layout','name'=>'order','meta_title'=>'订单管理','meta_icon'=>'el-icon-s-order','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--6
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/financial','component'=>'Layout','name'=>'financial','meta_title'=>'财务管理','meta_icon'=>'el-icon-money','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--7
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/article','component'=>'Layout','name'=>'article','meta_title'=>'文章管理','meta_icon'=>'education','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--8
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/picture','component'=>'Layout','name'=>'','meta_title'=>'图片空间','meta_icon'=>'el-icon-picture','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--9
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/log','component'=>'Layout','name'=>'log','meta_title'=>'日志管理','meta_icon'=>'el-icon-notebook-1','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--10
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/message','component'=>'Layout','name'=>'message','meta_title'=>'消息通知','meta_icon'=>'message','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
            //|--11
            ['created_time'=>time(),'parent_id'=>0,'deep'=>1,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'/suggest','component'=>'Layout','name'=>'','meta_title'=>'建议反馈','meta_icon'=>'el-icon-message','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
        ];

        //二级类目
        $twoDeepData = [
            //|--1 系统设置
                //|--|--12
                ['created_time'=>time(),'parent_id'=>1,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'platformConfig','component'=>'platformConfig','name'=>'platformConfig','meta_title'=>'平台配置','meta_icon'=>'international','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--13
                ['created_time'=>time(),'parent_id'=>1,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'system','component'=>'system','name'=>'system','meta_title'=>'系统配置','meta_icon'=>'component','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--14
                ['created_time'=>time(),'parent_id'=>1,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'permission','component'=>'permission','name'=>'Permission','meta_title'=>'菜单管理','meta_icon'=>'tree-table','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--15
                ['created_time'=>time(),'parent_id'=>1,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'role','component'=>'role','name'=>'Role','meta_title'=>'角色管理','meta_icon'=>'el-icon-s-custom','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--16
                ['created_time'=>time(),'parent_id'=>1,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'group','component'=>'group','name'=>'group','meta_title'=>'分类管理','meta_icon'=>'tree','meta_affix'=>0,'alwaysShow'=>1,'hidden'=>0,'meta_noCache'=>0],
                //|--|--17
                ['created_time'=>time(),'parent_id'=>1,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'level','component'=>'level','name'=>'level','meta_title'=>'级别管理','meta_icon'=>'el-icon-s-data','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--18
                ['created_time'=>time(),'parent_id'=>1,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'region','component'=>'region','name'=>'region','meta_title'=>'地区管理','meta_icon'=>'el-icon-location','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--19
                ['created_time'=>time(),'parent_id'=>1,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'bank','component'=>'bank','name'=>'bank','meta_title'=>'银行管理','meta_icon'=>'el-icon-bank-card','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //--2 业务设置
                //|--|--20
                ['created_time'=>time(),'parent_id'=>2,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'common','component'=>'common','name'=>'common','meta_title'=>'通用设置','meta_icon'=>'el-icon-setting','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],

            //|--3 用户管理
                //|--|--21
                ['created_time'=>time(),'parent_id'=>3,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'admin','component'=>'admin','name'=>'userAdmin','meta_title'=>'管理员管理','meta_icon'=>'el-icon-s-custom','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--22
                ['created_time'=>time(),'parent_id'=>3,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'user','component'=>'user','name'=>'user','meta_title'=>'用户管理','meta_icon'=>'el-icon-user','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--4 产品管理
                //|--|--23
                ['created_time'=>time(),'parent_id'=>4,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'goodsList','component'=>'goodsList','name'=>'goodsList','meta_title'=>'产品列表','meta_icon'=>'el-icon-tickets','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--24
                ['created_time'=>time(),'parent_id'=>4,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'goodsCheck','component'=>'goodsCheck','name'=>'goodsCheck','meta_title'=>'等待审核','meta_icon'=>'el-icon-s-check','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--5 订单管理
                //|--|--25
                ['created_time'=>time(),'parent_id'=>5,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'orderList','component'=>'orderList','name'=>'orderList','meta_title'=>'订单列表','meta_icon'=>'list','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--26
                ['created_time'=>time(),'parent_id'=>5,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'exceptionOrder','component'=>'exceptionOrder','name'=>'exceptionOrder','meta_title'=>'异常订单','meta_icon'=>'el-icon-warning','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--6 财务管理
                //|--|--27
                ['created_time'=>time(),'parent_id'=>6,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'withdraw','component'=>'withdraw','name'=>'withdraw','meta_title'=>'提现管理','meta_icon'=>'el-icon-s-promotion','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--7 文章管理
                //|--|--28
                ['created_time'=>time(),'parent_id'=>7,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'notice','component'=>'notice','name'=>'notice','meta_title'=>'公告管理','meta_icon'=>'el-icon-postcard','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--29
                ['created_time'=>time(),'parent_id'=>7,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'systemArticle','component'=>'systemArticle','name'=>'systemArticle','meta_title'=>'系统文章','meta_icon'=>'el-icon-document-copy','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
             //|--8 图片空间
                //|--|--30
                ['created_time'=>time(),'parent_id'=>8,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'album','component'=>'album','name'=>'album','meta_title'=>'我的相册','meta_icon'=>'el-icon-collection','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--9 日志管理
                //|--|--31
                ['created_time'=>time(),'parent_id'=>9,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'loginLog','component'=>'loginLog','name'=>'LoginLog','meta_title'=>'登录日志','meta_icon'=>'el-icon-notebook-2','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--32
                ['created_time'=>time(),'parent_id'=>9,'deep'=>2,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'eventLog','component'=>'eventLog','name'=>'eventLog','meta_title'=>'事件日志','meta_icon'=>'el-icon-view','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
        ];

        //三级类目
        $threeDeepData = [
            //|--|--13 系统配置
                 //|--|--|--33
                ['created_time'=>time(),'parent_id'=>13,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'systemConfig','component'=>'systemConfig','name'=>'systemConfig','meta_title'=>'参数配置','meta_icon'=>'component','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--34
                ['created_time'=>time(),'parent_id'=>13,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'voiceConfig','component'=>'voiceConfig','name'=>'voiceConfig','meta_title'=>'提示配置','meta_icon'=>'el-icon-bell','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--|--12 平台配置
                //|--|--|--35
                ['created_time'=>time(),'parent_id'=>12,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'cacheConfig','component'=>'cacheConfig','name'=>'cacheConfig','meta_title'=>'缓存设置','meta_icon'=>'el-icon-picture-outline-round','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--36
                ['created_time'=>time(),'parent_id'=>12,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'phoneIndexBanner','component'=>'phoneIndexBanner','name'=>'phoneIndexBanner','meta_title'=>'首页轮播','meta_icon'=>'el-icon-picture-outline','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--|--16 分类管理
                //|--|--|--37
                ['created_time'=>time(),'parent_id'=>16,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'goodsClass','component'=>'goodsClass','name'=>'goodsClass','meta_title'=>'产品分类','meta_icon'=>'el-icon-present','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--38
                ['created_time'=>time(),'parent_id'=>16,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'category','component'=>'category','name'=>'category','meta_title'=>'文章分类','meta_icon'=>'documentation','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--39
                ['created_time'=>time(),'parent_id'=>16,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'label','component'=>'label','name'=>'label','meta_title'=>'标签管理','meta_icon'=>'el-icon-s-flag','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--|--17 级别管理
                //|--|--|--40
                ['created_time'=>time(),'parent_id'=>17,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'levelItem','component'=>'levelItem','name'=>'levelItem','meta_title'=>'级别条件','meta_icon'=>'size','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--41
                ['created_time'=>time(),'parent_id'=>17,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'userLevel','component'=>'userLevel','name'=>'userLevel','meta_title'=>'用户级别','meta_icon'=>'peoples','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--|--20 通用设置
                //|--|--|--42
                ['created_time'=>time(),'parent_id'=>20,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'gather','component'=>'gather','name'=>'gather','meta_title'=>'集合设置','meta_icon'=>'el-icon-more','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--|--22 用户管理
                //|--|--|--43
                ['created_time'=>time(),'parent_id'=>22,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'userList','component'=>'userList','name'=>'userList','meta_title'=>'用户列表','meta_icon'=>'list','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--44
                ['created_time'=>time(),'parent_id'=>22,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'userCheck','component'=>'userCheck','name'=>'userCheck','meta_title'=>'等待认证','meta_icon'=>'el-icon-s-check','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--45
                ['created_time'=>time(),'parent_id'=>22,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'editUser','component'=>'editUser','name'=>'editUser','meta_title'=>'编辑用户','meta_icon'=>'edit','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>1,'meta_noCache'=>1],
            //|--|--31 登录日志
                //|--|--|--46
                ['created_time'=>time(),'parent_id'=>31,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'phoneLogin','component'=>'phoneLogin','name'=>'phoneLogin','meta_title'=>'手机登录','meta_icon'=>'el-icon-phone','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--47
                ['created_time'=>time(),'parent_id'=>31,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'adminLogin','component'=>'adminLogin','name'=>'adminLogin','meta_title'=>'后台登录','meta_icon'=>'list','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
            //|--|--32 事件日志
                //|--|--|--48
                ['created_time'=>time(),'parent_id'=>32,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'phoneEvent','component'=>'phoneEvent','name'=>'phoneEvent','meta_title'=>'手机事件','meta_icon'=>'el-icon-phone','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],
                //|--|--|--49
                ['created_time'=>time(),'parent_id'=>32,'deep'=>3,'sort'=>100,'is_menu'=>1,'switch'=>1,'path'=>'adminEvent','component'=>'adminEvent','name'=>'adminEvent','meta_title'=>'后台事件','meta_icon'=>'list','meta_affix'=>0,'alwaysShow'=>0,'hidden'=>0,'meta_noCache'=>0],

        ];

        //四级类目
        $fourDeepData = [

        ];

        $permissionData = array_merge($oneDeepData,$twoDeepData,$threeDeepData,$fourDeepData);

        DB::table('permission')->insert($permissionData);

    }
}
