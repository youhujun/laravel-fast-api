<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 19:41:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-14 23:45:04
 * @FilePath: \app\Service\Facade\Admin\System\Platform\AdminCacheConfigFacadeService.php
 */

namespace App\Service\Facade\Admin\System\Platform;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Redis;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\Admin\Admin;

/**
 * @see \App\Facade\Admin\System\Platform\AdminCacheConfigFacade
 */
class AdminCacheConfigFacadeService
{
   public function test()
   {
       echo "AdminCacheConfigFacadeService test";
   }

   /**
    * 清理平台redis缓存
    *
    * @return void
    */
   public function cleanConfigCache()
   {
        //地区
        Redis::hdel('system:config','allRegions');
        Redis::hdel('system:config','treeRegions');
        //角色
        Redis::hdel('system:config','treeRoles');
        //产品分类
        Redis::hdel('system:config','treeGoodsClass');
        //文章分类
        Redis::hdel('system:config','treeCategory');
        //标签分类
        Redis::hdel('system:config','treeLabel');
        //系统配置
        Redis::hdel('system:config','listSystemConfig');
        Redis::hdel('system:config','isSetSystemConfig');
        //权限路由
        Redis::hdel('system:config','permission');
        Redis::hdel('system:config','develop_permission');

        $result = code(['code'=>0,'msg'=>'清理缓存成功!']);

        return $result;
   }

   /**
    * 清理地区缓存
    *
    * @return void
    */
   public function cleanRegionCache()
   {
        Redis::hdel('system:config','allRegions');
        Redis::hdel('system:config','treeRegions');

        $result = code(['code'=>0,'msg'=>'清理地区缓存成功!']);

        return $result;
   }

   /**
    * 清理角色缓存
    *
    * @return void
    */
   public function cleanRoleCache()
   {

        Redis::hdel('system:config','treeRoles');

        $result = code(['code'=>0,'msg'=>'清理角色缓存成功!']);

        return $result;
   }

   /**
    * 清理产品分类混存
    *
    * @return void
    */
   public function cleanGoodsClassCache()
   {

        Redis::hdel('system:config','treeGoodsClass');

        $result = code(['code'=>0,'msg'=>'清理产品分类缓存成功!']);

        return $result;
   }

   /**
    * 清理文章分类缓存
    *
    * @return void
    */
   public function cleanCategoryCache()
   {
        Redis::hdel('system:config','treeCategory');

        $result = code(['code'=>0,'msg'=>'清理文章分类缓存成功!']);

        return $result;
   }

   /**
    * 清理分类标签缓存
    *
    * @return void
    */
   public function cleanLabelCache()
   {
        Redis::hdel('system:config','treeLabel');

        $result = code(['code'=>0,'msg'=>'清理标签分类缓存成功!']);

        return $result;
   }

   /**
    * 清理系统配置缓存
    *
    * @return void
    */
   public function cleanSystemConfigCache()
   {
        Redis::hdel('system:config','listSystemConfig');
        Redis::hdel('system:config','isSetSystemConfig');

        $result = code(['code'=>0,'msg'=>'清理系统配置缓存成功!']);

        return $result;
   }

   /**
    * 情路权限路由
    *
    * @return void
    */
   public function cleanPermissionCache()
   {
        Redis::hdel('system:config','permission');
        Redis::hdel('system:config','develop_permission');

        $result = code(['code'=>0,'msg'=>'清理权限菜单缓存成功!']);

        return $result;
   }


   /**
    * 清理登录用户信息缓存
    *
    * @param User $user
    * @return void
    */
   public function cleanLoginUserInfoCache(Admin $admin)
   {

        Redis::hdel("admin_info:admin_info",$admin->id);

        $result = code(['code'=>0,'msg'=>'清理登录用户缓存成功!']);

        return $result;
   }

}
