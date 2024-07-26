<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-05 10:26:56
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 11:19:30
 * @FilePath: \config\custom\admin\event\admin_system_event.php
 */

return [
         //|--系统配置
    //|--|--平台设置
    //|--|--|--缓存设置
    //|--|--|--首页轮播
    'AddPhoneBanner' => [ 'code' => 10110, 'info' => '添加首页轮播图' ,'event'=>'AddPhoneBanner'],
    'UpdatePhoneBanner' => [ 'code' => 10120, 'info' => '修改首页轮播图','event'=>'UpdatePhoneBanner' ],
    'DeletePhoneBanner' => [ 'code' => 10130, 'info' => '删除首页轮播图','event'=>'DeletePhoneBanner' ],
    'RestorePhoneBanner' => [ 'code' => 10140, 'info' => '恢复首页轮播图','event'=>'RestorePhoneBanner' ],
    //|--|--|--首页轮播--详情
    'UpdatePhoneBannerPicture' => [ 'code' =>10210, 'info' => '修改首页轮播图图片','event'=>'UpdatePhoneBannerPicture'],
    'UpdatePhoneBannerUrl' => [ 'code' => 10220, 'info' => '修改首页轮播图跳转' ,'event'=>'UpdatePhoneBannerUrl'],
    'UpdatePhoneBannerSort' => [ 'code' => 10230, 'info' => '修改首页轮播图排序','event'=>'UpdatePhoneBannerSort' ],
    'UpdatePhoneBannerRemarkInfo' => [ 'code' => 10240, 'info' => '修改首页轮播图备注','event'=>'UpdatePhoneBannerRemarkInfo' ],

    //|--|--系统设置
    //|--|--|--参数配置
    'AddSystemConfig' => [ 'code' => 10000, 'info' => '添加系统配置','event'=>'AddSystemConfig'],
    'UpdateSystemConfig' => [ 'code' => 10000, 'info' => '修改系统配置','event'=>'UpdateSystemConfig'],
    'DeleteSystemConfig' => [ 'code' => 10000, 'info' => '删除系统配置','event'=>'DeleteSystemConfig'],
    'MultipleDeleteSystemConfig' => [ 'code' => 10000, 'info' => '批量删除系统配置','event'=>'MultipleDeleteSystemConfig'],
    //|--|--|--提示配置
    'AddSystemVoiceConfig' => [ 'code' => 10000, 'info' => '添加系统配置','event'=>'AddSystemVoiceConfig'],
    'UpdateSystemVoiceConfig' => [ 'code' => 10000, 'info' => '修改系统配置','event'=>'UpdateSystemVoiceConfig'],
    'DeleteSystemVoiceConfig' => [ 'code' => 10000, 'info' => '删除系统配置','event'=>'DeleteSystemVoiceConfig'],
    'MultipleDeleteSystemVoiceConfig' => [ 'code' => 10000, 'info' => '批量删除系统配置','event'=>'MultipleDeleteSystemVoiceConfig'],
    //|--|--菜单管理
    'AddMenu'=>[ 'code' => 19010, 'info' => '添加菜单','event'=>'AddMenu'],
    'UpdateMenu'=>[ 'code' => 19020, 'info' => '更新菜单','event'=>'UpdateMenu' ],
    'MoveMenu'=>[ 'code' => 19030, 'info' => '移动菜单','event'=>'MoveMenu' ],
    'DeleteMenu'=>[ 'code' => 19040, 'info' => '删除菜单','event'=>'DeleteMenu' ],
    'DisableMenu'=>[ 'code' => 19050, 'info' => '关闭菜单','event'=>'DisableMenu' ],
    'AbleMenu'=>[ 'code' => 19060, 'info' => '开启菜单' ,'event'=>'AbleMenu'],
    //|--|--角色管理
    'AddRole' => [ 'code' =>18110, 'info' => '添加角色','event'=>'AddRole' ],
    'UpdateRole' => [ 'code' => 18120, 'info' => '修改角色','event'=>'UpdateRole' ],
    'MoveRole' => [ 'code' => 18130, 'info' => '移动角色','event'=>'MoveRole' ],
    'DeleteRole' => [ 'code' => 18140, 'info' => '删除角色','event'=>'DeleteRole' ],
    'ResetRolePermission' => [ 'code' => 18150, 'info' => '重新赋值角色权限','event'=>'ResetRolePermission' ],
    //|--|--分类管理
    //|--|--|--产品分类
    'AddGoodsClass' => [ 'code' => 17110, 'info' => '添加产品分类' ,'event'=>'AddGoodsClass'],
    'UpdateGoodsClass' => [ 'code' => 17120, 'info' => '修改产品分类','event'=>'UpdateGoodsClass' ],
    'MoveGoodsClass' => [ 'code' => 17130, 'info' => '移动产品分类','event'=>'MoveGoodsClass' ],
    'DeleteGoodsClass' => [ 'code' => 17140, 'info' => '删除产品分类','event'=>'DeleteGoodsClass' ],
    //|--|--|--文章分类
    'AddCategory' => [ 'code' => 16110, 'info' => '添加文章分类','event'=>'AddCategory' ],
    'UpdateCategory' => [ 'code' => 16120, 'info' => '修改文章分类','event'=>'UpdateCategory' ],
    'MoveCategory' => [ 'code' => 16130, 'info' => '移动文章分类','event'=>'MoveCategory' ],
    'DeleteCategory' => [ 'code' => 16140, 'info' => '删除文章分类','event'=>'DeleteCategory' ],
    //|--|--|--标签管理
    'AddLabel' => [ 'code' => 15110, 'info' => '添加标签','event'=>'AddLabel' ],
    'UpdateLabel' => [ 'code' => 15110, 'info' => '修改标签','event'=>'UpdateLabel' ],
    'MoveLabel' => [ 'code' => 15110, 'info' => '移动标签','event'=>'MoveLabel' ],
    'DeleteLabel' => [ 'code' => 15110, 'info' => '删除标签','event'=>'DeleteLabel' ],
    //|--|--级别管理
    //|--|--|--级别条件
    'AddLevelItem' => [ 'code' => 10000, 'info' => '添加级别配置项','event'=>'AddLevelItem' ],
    'UpdateLevelItem' => [ 'code' => 10000, 'info' => '修改级别配置项','event'=>'UpdateLevelItem' ],
    'DeleteLevelItem' => [ 'code' => 10000, 'info' => '删除级别配置项','event'=>'DeleteLevelItem' ],
    'MultipleDeleteLevelItem' => [ 'code' => 10000, 'info' => '批量删除级别配置项','event'=>'MultipleDeleteLevelItem' ],
    //|--|--|--用户级别
    'AddUserLevel' => [ 'code' => 10000, 'info' => '添加用户级别','event'=>'AddUserLevel' ],
    'UpdateUserLevel' => [ 'code' => 10000, 'info' => '修改用户级别','event'=>'UpdateUserLevel' ],
    'DeleteUserLevel' => [ 'code' => 10000, 'info' => '删除用户级别','event'=>'DeleteUserLevel' ],
    'MultipleDeleteUserLevel' => [ 'code' => 10000, 'info' => '批量删除用户级别','event'=>'MultipleDeleteUserLevel' ],
    'AddUserLevelItemUnion' => [ 'code' => 10000, 'info' => '添加用户级别配置项','event'=>'AddUserLevelItemUnion' ],
    'UpdateUserLevelItemUnion' => [ 'code' => 10000, 'info' => '修改用户级别配置项','event'=>'UpdateUserLevelItemUnion' ],
    'DeleteUserLevelItemUnion' => [ 'code' => 10000, 'info' => '删除用户级别配置项','event'=>'DeleteUserLevelItemUnion' ],

    //|--|--地区管理
    'AddRegion' => [ 'code' => 10000, 'info' => '添加地区','event'=>'AddRegion' ],
    'UpdateRegion' => [ 'code' => 10000, 'info' => '修改地区','event'=>'UpdateRegion' ],
    'MoveRegion' => [ 'code' => 10000, 'info' => '移动地区','event'=>'MoveRegion' ],
    'DeleteRegion' => [ 'code' => 10000, 'info' => '删除地区','event'=>'DeleteRegion' ],
    //|--|--银行管理
    'AddBank' => [ 'code' => 10000, 'info' => '添加银行','event'=>'AddBank' ],
    'UpdateBank' => [ 'code' => 10000, 'info' => '修改银行','event'=>'UpdateBank' ],
    'DeleteBank' => [ 'code' => 10000, 'info' => '删除银行' ,'event'=>'DeleteBank'],
    'MultipleDeleteBank' => [ 'code' => 10000, 'info' => '批量删除银行','event'=>'MultipleDeleteBank' ],
];
