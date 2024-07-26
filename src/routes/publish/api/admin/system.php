<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 15:57:27
 * @FilePath: \routes\api\admin\system.php
 */

/**模板路由 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$namespace = 'App\\Http\\Controllers\\Admin\\System';

/**
 * 后端模版
 */
 Route::prefix(config('custom.version'))->namespace($namespace)->middleware('admin.login')->group(function()
{
    Route::prefix('admin')->group(function()
    {
        //后台管理-系统设置-平台配置
        Route::namespace('Platform')->group(function()
        {
            /**
             * 后台管理-系统设置-平台配置-缓存设置
            * bind
            * @see \App\Http\Controllers\Admin\System\Platform\CacheConfigController
            */
            Route::controller(CacheConfigController::class)->group(function()
            {
                    //系统缓存
                        //清理全部配置缓存
                        Route::any('cleanConfigCache','cleanConfigCache');
                        //清理地区缓存
                        Route::any('cleanRegionCache','cleanRegionCache');
                        //清理角色缓存
                        Route::any('cleanRoleCache','cleanRoleCache');
                        //清理产品分类缓存
                        Route::any('cleanGoodsClassCache','cleanGoodsClassCache');
                        //清理文章分类缓存
                        Route::any('cleanCategoryCache','cleanCategoryCache');
                        //清理标签分类缓存
                        Route::any('cleanLabelCache','cleanLabelCache');
                        //清理系统配置缓存
                        Route::any('cleanSystemConfigCache','cleanSystemConfigCache');
                        //清理权限路由缓存
                        Route::any('cleanPermissionCache','cleanPermissionCache');
                        //用户缓存
                        //清理用户信息缓存
                        Route::any('cleanLoginUserInfoCache','cleanLoginUserInfoCache');

            });

            /**
             * |--|--|--首页轮播
             * @see  \App\Http\Controllers\Admin\System\Platform\PhoneBannerController
             */
            Route::controller(PhoneBannerController::class)->group(function()
            {
                //获取轮播图
                Route::post('getPhoneBanner','getPhoneBanner');
                //添加轮播图
                Route::post('addPhoneBanner','addPhoneBanner');
                //修改轮播图
                Route::post('updatePhoneBanner','updatePhoneBanner');
                //删除轮播图
                Route::post('deletePhoneBanner','deletePhoneBanner');

            });

            //轮播图详情
            Route::namespace('PhoneBanner')->group(function()
            {
                 /**
                 * @see \App\Http\Controllers\Admin\System\Platform\PhoneBanner\PhoneBannerDetailsController
                 */
                Route::controller(PhoneBannerDetailsController::class)->group(function()
                {
                    //修改轮播图图片
                    Route::post('updatePhoneBannerPicture','updatePhoneBannerPicture');
                    //修改轮播图跳转
                    Route::post('updatePhoneBannerUrl','updatePhoneBannerUrl');
                    //修改轮播图排序
                    Route::post('updatePhoneBannerSort','updatePhoneBannerSort');
                    //修改轮播图备注
                    Route::post('updatePhoneBannerBakInfo','updatePhoneBannerBakInfo');

                });

            });

        });

        //后台管理-系统设置-系统配置
        Route::namespace('SystemConfig')->group(function()
        {
            /**
             * @see \App\Http\Controllers\Admin\System\SystemConfig\SystemConfigController
             */
            Route::controller(SystemConfigController::class)->group(function()
            {
                //获取系统配置
                Route::post('getSystemConfig','getSystemConfig');
                //添加系统配置
                Route::post('addSystemConfig','addSystemConfig');
                //更新系统配置
                Route::post('updateSystemConfig','updateSystemConfig');
                //删除系统配置
                Route::post('deleteSystemConfig','deleteSystemConfig');
                // 批量删除
                Route::post('multipleDeleteSystemConfig','multipleDeleteSystemConfig');
            });


             /**
             * @see \App\Http\Controllers\Admin\System\SystemConfig\VoiceConfigController
             */
            Route::controller(VoiceConfigController::class)->group(function()
            {
                //获取所有提示配置
                Route::any('getAllSystemVoiceConfig','getAllSystemVoiceConfig');
                //获取提示配置
                Route::post('getVoiceConfig','getVoiceConfig');
                //添加提示配置
                Route::post('addVoiceConfig','addVoiceConfig');
                //更新提示配置
                Route::post('updateVoiceConfig','updateVoiceConfig');
                //删除提示配置
                Route::post('deleteVoiceConfig','deleteVoiceConfig');
                // 批量删除
                Route::post('multipleDeleteVoiceConfig','multipleDeleteVoiceConfig');
            });
        });


        // 后台管理-系统设置-菜单管理
        Route::namespace('Permission')->group(function()
        {
            /**
            * bind
            * @see \App\Http\Controllers\Admin\System\Permission\PermissionController
            */
            Route::controller(PermissionController::class)->group(function()
            {
                //添加路由
                Route::post('addMenu','addMenu');
                //更新路由
                Route::post('updateMenu','updateMenu');
                //移动菜单
                Route::post('moveMenu','moveMenu');
                //更新路由
                Route::post('deleteMenu','deleteMenu');
                //修改路由状态
                Route::post('switchMenu','switchMenu');

            });
        });

        // 后台管理-系统设置-角色管理
        Route::namespace('Role')->group(function()
        {
            /**
            * bind
            * @see \App\Http\Controllers\Admin\System\Role\RoleController
            */
            Route::controller(RoleController::class)->group(function()
            {
                //添加路由
                Route::get('getTreeRole','getTreeRole');
                //更新路由
                Route::post('addRole','addRole');
                //移动菜单
                Route::post('updateRole','updateRole');
                //更新路由
                Route::post('moveRole','moveRole');
                //修改路由状态
                Route::post('deleteRole','deleteRole');
                //修改角色权限
                Route::post('resetRolePermission','resetRolePermission');

            });
        });

        // 后台管理-系统设置-分类
        Route::namespace('Group')->group(function()
        {
            /**
             * 产品分类
            * bind
            * @see \App\Http\Controllers\Admin\System\Group\GoodsClassController
            */
            Route::controller(GoodsClassController::class)->group(function()
            {
                //添加产品分类
                Route::get('getTreeGoodsClass','getTreeGoodsClass');
                //更新产品分类
                Route::post('addGoodsClass','addGoodsClass');
                //移动产品分类
                Route::post('updateGoodsClass','updateGoodsClass');
                //更新产品分类
                Route::post('moveGoodsClass','moveGoodsClass');
                //删除产品分类
                Route::post('deleteGoodsClass','deleteGoodsClass');

            });

            /**
             *|--|--|--章分类
            * bind
            * @see \App\Http\Controllers\Admin\System\Group\CategoryController
            */
            Route::controller(CategoryController::class)->group(function()
            {
                //获取树形文章分类
                Route::get('getTreeCategory','getTreeCategory');
                //添加文章分类
                Route::post('addCategory','addCategory');
                //更新文章分类
                Route::post('updateCategory','updateCategory');
                //移动树形结构
                Route::post('moveCategory','moveCategory');
                //更新文章分类
                Route::post('deleteCategory','deleteCategory');

            });

            /**
             *|--|--|--标签管理
            * bind
            * @see \App\Http\Controllers\Admin\System\Group\LabelController
            */
            Route::controller(LabelController::class)->group(function()
            {
                //获取树形标签分类
                Route::get('getTreeLabel','getTreeLabel');
                //添加标签分类
                Route::post('addLabel','addLabel');
                //更新标签分类
                Route::post('updateLabel','updateLabel');
                //移动树形结构
                Route::post('moveLabel','moveLabel');
                //更新标签分类
                Route::post('deleteLabel','deleteLabel');

            });
        });

        //后台管理-系统设置-级别管理
        Route::namespace('Level')->group(function()
        {
            /**
             *|--|--|--级别条件
            * bind
            * @see \App\Http\Controllers\Admin\System\level\LevelItemController
            */
            Route::controller(LevelItemController::class)->group(function()
            {
                //获取级别条件
                Route::post('getLevelItem','getLevelItem');
                //添加级别条件
                Route::post('addLevelItem','addLevelItem');
                //更新级别条件
                Route::post('updateLevelItem','updateLevelItem');
                //删除级别条件
                Route::post('deleteLevelItem','deleteLevelItem');
                //批量删除级别条件
                Route::post('multipleDeleteLevelItem','multipleDeleteLevelItem');

                //|--|--|--|--级别条件选项
                //获取默认级别条件
                Route::get('defaultLevelItem','defaultLevelItem');
                //查找级别条件
                Route::post('findLevelItem','findLevelItem');
            });

            /**
                 *|--|--|--用户级别
                * bind
                * @see \App\Http\Controllers\Admin\System\level\UserLevelController
                */
            Route::controller(UserLevelController::class)->group(function()
            {
                //|--|--|--用户级别选项
                //获取默认用户级别
                Route::get('defaultUserLevel','defaultUserLevel');
                //查找用户级别
                Route::post('findUserLevel','findUserLevel');
                //|--|--|--用户级别
                //获取用户级别
                Route::post('getUserLevel','getUserLevel');
                //添加用户级别
                Route::post('addUserLevel','addUserLevel');
                //更新用户级别
                Route::post('updateUserLevel','updateUserLevel');
                //删除用户级别
                Route::post('deleteUserLevel','deleteUserLevel');
                //批量删除用户级别
                Route::post('multipleDeleteUserLevel','multipleDeleteUserLevel');
                //|--|--|--用户级别配置项
                //添加用户级级别配置项
                Route::post('addUserLevelItemUnion','addUserLevelItemUnion');
                //修改用户级级别配置项
                Route::post('updateUserLevelItemUnion','updateUserLevelItemUnion');
                //删除用户级级别配置项
                Route::post('deleteUserLevelItemUnion','deleteUserLevelItemUnion');

            });
        });

        // 后台管理-系统设置-地区管理
        Route::namespace('Region')->group(function()
        {
            /**
            * bind
            * @see \App\Http\Controllers\Admin\System\Region\RegionController
            */
            Route::controller(RegionController::class)->group(function()
            {
                 //获取树形地区
                Route::get('getTreeRegions','getTreeRegion');
                //获取所有地区
                Route::get('getRegions','getAllRegion');
                //添加地区
                Route::post('addRegion','addRegion');
                //更新地区
                Route::post('updateRegion','updateRegion');
                //移动地区
                Route::post('moveRegion','moveRegion');
                //删除地区
                Route::post('deleteRegion','deleteRegion');

            });
        });

        // 后台管理-系统设置-银行管理
        Route::namespace('Bank')->group(function()
        {
            /**
            * bind
            * @see \App\Http\Controllers\Admin\System\Bank\BankController
            */
            Route::controller(BankController::class)->group(function()
            {
                //获取常用银行
                Route::get('defaultBank','defaultBank');
                //查找银行
                Route::post('findBank','findBank');
                //获取银行
                Route::post('getBank','getBank');
                //添加银行
                Route::post('addBank','addBank');
                //更新银行
                Route::post('updateBank','updateBank');
                //删除银行
                Route::post('deleteBank','deleteBank');
                //批量删除银行
                Route::post('multipleDeleteBank','multipleDeleteBank');

            });
        });
   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});


