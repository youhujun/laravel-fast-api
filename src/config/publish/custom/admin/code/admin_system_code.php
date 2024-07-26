<?php

return [
    //|--系统配置
    //|--系统配置
    //|--|--系统设置
        //参数设置
        'GetsystemConfigError'=>[ 'code'=>10000, 'msg'=>'获取系统配置失败','errot'=>'GetsystemConfigError' ],
        //添加系统配置
        'AddSystemConfigError'=>[ 'code'=>10000, 'msg'=>'添加系统配置失败','errot'=>'AddSystemConfigError' ],
        'AddSystemConfigEventError'=>[ 'code'=>10000, 'msg'=>'添加系统配置事件失败','errot'=>'AddSystemConfigEventError' ],
        //修改系统配置
        'UpdateSystemConfigError'=>[ 'code'=>10000, 'msg'=>'更新系统配置失败','errot'=>'UpdateSystemConfigError' ],
        'UpdateSystemConfigEventError'=>[ 'code'=>10000, 'msg'=>'更新系统配置事件失败' ,'errot'=>'UpdateSystemConfigEventError'],
        //删除系统配置
        'DeleteSystemConfigError'=>[ 'code'=>10000, 'msg'=>'删除系统配置失败','errot'=>'DeleteSystemConfigError' ],
        'DeleteSystemConfigEventError'=>[ 'code'=>10000, 'msg'=>'删除系统配置事件失败','errot'=>'DeleteSystemConfigEventError' ],
        //批量删除
        'MultipleRestoreSystemConfigError'=>[ 'code'=>10000, 'msg'=>'批量删除系统配置失败','errot'=>'MultipleRestoreSystemConfigError' ],
        'MultipleRestoreSystemConfigEventError'=>[ 'code'=>10000, 'msg'=>'批量删除系统配置失败','errot'=>'MultipleRestoreSystemConfigEventError' ],
    //|--|--系统设置
        //提示配置
        'AddSystemVoiceConfigError'=>[ 'code'=>10000, 'msg'=>'添加提示配置失败','errot'=>'AddSystemVoiceConfigError' ],
        'UpdateSystemVoiceConfigError'=>[ 'code'=>10000, 'msg'=>'修改提示配置失败','errot'=>'AddSystemVoiceConfigError' ],
        'DeleteSystemVoiceConfigError'=>[ 'code'=>10000, 'msg'=>'删除提示配置失败','errot'=>'DeleteSystemVoiceConfigError' ],
        'MultipleDeleteSystemVoiceConfigError'=>[ 'code'=>10000, 'msg'=>'批量删除提示配置失败','errot'=>'DeleteSystemVoiceConfigError' ],
    //|--|--|--首页轮播
    //获取轮播图
        'GetPhoneBannerError'=>[ 'code'=>10000, 'msg'=>'获取首页轮播失败','error'=>'GetPhoneBannerError' ],
        //添加轮播图
        'AddPhoneBannerError'=>[ 'code'=>10000, 'msg'=>'添加首页轮播失败','error'=>'AddPhoneBannerError' ],
        'AddPhoneBannerEventError'=>[ 'code'=>10000, 'msg'=>'添加首页轮播事件失败','error'=>'AddPhoneBannerEventError' ],
        //修改轮播图
        'UpdatePhoneBannerError'=>[ 'code'=>10000, 'msg'=>'修改首页轮播失败','error'=>'UpdatePhoneBannerError'],
        'UpdatePhoneBannerEventError'=>[ 'code'=>10000, 'msg'=>'修改首页轮播事件失败','error'=>'UpdatePhoneBannerEventError' ],
        //删除轮播图
        'DeletePhoneBannerError'=>[ 'code'=>10000, 'msg'=>'删除首页轮播失败','error'=>'DeletePhoneBannerError' ],
        'DeletePhoneBannerEventError'=>[ 'code'=>10000, 'msg'=>'删除首页轮播事件失败','error'=>'DeletePhoneBannerEventError' ],
        'RestorePhoneBannerError'=>[ 'code'=>10000, 'msg'=>'恢复首页轮播失败','error'=>'RestorePhoneBannerError' ],
        'RestorePhoneBannerEventError'=>[ 'code'=>10000, 'msg'=>'恢复首页轮播事件失败','error'=>'RestorePhoneBannerEventError' ],

        //轮播图详情
        //轮播图详情--图片
        'UpdatePhoneBannerPictureError'=>[ 'code'=>10210, 'msg'=>'修改首页轮播图片失败','error'=>'UpdatePhoneBannerPictureError' ],
        'UpdatePhoneBannerPictureEventError'=>[ 'code'=>10220, 'msg'=>'修改首页轮播图片事件失败','error'=>'UpdatePhoneBannerPictureEventError' ],
        //轮播图详情--链接
        'UpdatePhoneBannerUrlError'=>[ 'code'=>10230, 'msg'=>'修改首页轮播跳转失败','error'=>'UpdatePhoneBannerUrlError' ],
        'UpdatePhoneBannerUrlEventError'=>[ 'code'=>10240, 'msg'=>'修改首页轮播跳转事件失败','error'=>'UpdatePhoneBannerUrlEventError' ],
        //轮播图详情--排序
        'UpdatePhoneBannerSortError'=>[ 'code'=>10250, 'msg'=>'修改首页轮播排序失败','error'=>'UpdatePhoneBannerSortError' ],
        'UpdatePhoneBannerSortEventError'=>[ 'code'=>10260, 'msg'=>'修改首页轮播排序事件失败','error'=>'UpdatePhoneBannerSortEventError' ],
        //轮播图详情--备注
        'UpdatePhoneBannerRemarkInfoError'=>[ 'code'=>10270, 'msg'=>'修改首页轮播备注失败','error'=>'GetPhoneBannerError' ],
        'UpdatePhoneBannerRemarkInfoEventError'=>[ 'code'=>10280, 'msg'=>'修改首页轮播备注事件失败','error'=>'GetPhoneBannerError' ],



    //|--系统配置
    //|--|--菜单管理
     //添加菜单
        'AddMenuError'=>[ 'code'=>10000, 'msg'=>'添加菜单失败' ,'error'=>'AddMenuError'],
        'AddMenuEventError'=>[ 'code'=>10000, 'msg'=>'添加菜单事件失败', 'error'=>'AddMenuEventError'],
        //更新菜单
        'UpdateMenuError'=>[ 'code'=>10000, 'msg'=>'更新菜单失败' ,'error'=>'UpdateMenuError'],
        'UpdateMenuDeepError'=>[ 'code'=>10000, 'msg'=>'更新菜单子级级别失败','error'=>'UpdateMenuDeepError' ],
        'UpdateMenuEventError'=>[ 'code'=>10000, 'msg'=>'更新菜单事件失败','error'=>'UpdateMenuEventError' ],
        //移动菜单
        'MoveMenuError'=>[ 'code'=>10000, 'msg'=>'移动菜单失败','error'=>'MoveMenuError' ],
        'MoveMenuDeepError'=>[ 'code'=>10000, 'msg'=>'移动菜单失子级失败' ,'error'=>'MoveMenuDeepError'],
        'MoveMenuEventError'=>[ 'code'=>10000, 'msg'=>'移动菜单事件失败','error'=>'MoveMenuEventError' ],
        //删除菜单
        'DeleteMenuError'=>[ 'code'=>10000, 'msg'=>'删除菜单失败','error'=>'DeleteMenuError' ],
        'DeleteMenuEventError'=>[ 'code'=>10000, 'msg'=>'删除菜单事件失败','error'=>'DeleteMenuEventError' ],
        //关闭开启菜单
        'DisableMenuError'=>[ 'code'=>10000, 'msg'=>'关闭菜单失败','error'=>'DisableMenuError' ],
        'DisableMenuEventError'=>[ 'code'=>10000, 'msg'=>'关闭菜单事件失败','error'=>'DisableMenuEventError' ],
        'AbleMenuError'=>[ 'code'=>10000, 'msg'=>'开启菜单失败','error'=>'AbleMenuError' ],
        'AbleMenuEventError'=>[ 'code'=>10000, 'msg'=>'开启菜单事件失败','error'=>'AbleMenuEventError' ],

    //|--系统配置
    //|--|--角色管理
        'GetRoleError'=>[ 'code'=>10000, 'msg'=>'获取角色失败','error'=>'GetRoleError' ],
        //添加角色
        'AddRoleError'=>[ 'code'=>10000, 'msg'=>'添加角色失败','error'=>'AddRoleError'],
        'AddRoleEventError'=>[ 'code'=>10000, 'msg'=>'添加角色事件失败','error'=>'AddRoleEventError'],
        //更新角色
        'UpdateRoleError'=>[ 'code'=>10000, 'msg'=>'更新角色失败','error'=>'UpdateRoleError' ],
        'UpdateRoleEventError'=>[ 'code'=>10000, 'msg'=>'更新角色事件失败','error'=>'UpdateRoleEventError' ],
        //移动角色
        'MoveRoleError'=>[ 'code'=>10000, 'msg'=>'移动角色失败','error'=>'MoveRoleError'],
        'MoveRoleChildrenDeepError'=>[ 'code'=>10000, 'msg'=>'移动角色子级失败','error'=>'MoveRoleChildrenDeepError'],
        'MoveRoleEventError'=>[ 'code'=>10000, 'msg'=>'移动角色事件失败','error'=>'MoveRoleEventError'],
        //删除角色
        'DeleteRoleError'=>[ 'code'=>10000, 'msg'=>'删除角色失败','error'=>'DeleteRoleError' ],
        'DeleteSystemRoleError'=>[ 'code'=>10000, 'msg'=>'删除系统角色失败','error'=>'DeleteSystemRoleError' ],
        'DeleteNoRoleError'=>[ 'code'=>10000, 'msg'=>'有子角色不允许删除','error'=>'DeleteNoRoleError' ],
        'DeleteNoUserRoleError'=>[ 'code'=>10000, 'msg'=>'有用户具有该角色不允许删除','error'=>'DeleteNoUserRoleError' ],
        //重置角色权限
        'ResetRolePermissionError'=>[ 'code'=>10000, 'msg'=>'重置角色权限失败','error'=>'ResetRolePermissionError' ],
        'DeleteBeforeRolePermissionError'=>[ 'code'=>10000, 'msg'=>'清理之前权限失败','error'=>'DeleteBeforeRolePermissionError' ],
        'InsertAfterRolePermissionError'=>[ 'code'=>10000, 'msg'=>'赋予新的权限失败','error'=>'InsertAfterRolePermissionError' ],
        'ResetRolePermissionEventError'=>[ 'code'=>10000, 'msg'=>'重置角色权限事件失败','error'=>'ResetRolePermissionEventError' ],

    //|--系统配置
    //|--|--分类管理
    //|--|--|--产品分类
        'GetGoodsClassError'=>[ 'code'=>10000, 'msg'=>'获取产品分类失败','error'=>'GetGoodsClassError' ],
        //添加分类
        'AddGoodsClassError'=>[ 'code'=>10000, 'msg'=>'添加分类失败','error'=>'AddGoodsClassError' ],
        'AddGoodsClassEventError'=>[ 'code'=>10000, 'msg'=>'添加分类事件失败','error'=>'AddGoodsClassEventError' ],
        //更新分类
        'UpdateClassError'=>[ 'code'=>10000, 'msg'=>'更新分类失败','error'=>'UpdateClassError' ],
        'UpdateClassEventError'=>[ 'code'=>10000, 'msg'=>'更新分类事件失败','error'=>'UpdateClassEventError' ],
        //移动分类
        'MoveGoodsClassError'=>[ 'code'=>10000, 'msg'=>'移动分类失败','error'=>'MoveGoodsClassError' ],
        'MoveGoodsClassEventError'=>[ 'code'=>10000, 'msg'=>'移动分类事件失败','error'=>'MoveGoodsClassEventError' ],
        //删除分类
        'DeleteGoodsClassError'=>[ 'code'=>10000, 'msg'=>'删除分类失败','error'=>'DeleteGoodsClassError' ],
        'DeleteHasChildrenError'=>[ 'code'=>10000, 'msg'=>'有子分类不允许删除','error'=>'DeleteHasChildrenError' ],
        'DeleteHasGoodsError'=>[ 'code'=>10000, 'msg'=>'有产品不允许删除','error'=>'DeleteHasGoodsError' ],
        'DeleteGoodsClassEventError'=>[ 'code'=>10000, 'msg'=>'删除分类事件失败','error'=>'DeleteGoodsClassEventError' ],

    //|--|--|--文章分类
        'GetCategoryError'=>[ 'code'=>10000, 'msg'=>'获取文章分类失败','error'=>'GetCategoryError' ],
        //添加分类
        'AddCategoryError'=>[ 'code'=>10000, 'msg'=>'添加文章分类失败','error'=>'AddCategoryError' ],
        'AddCategoryEventError'=>[ 'code'=>10000, 'msg'=>'添加文章分类事件失败','error'=>'AddCategoryEventError'],
        //更新分类
        'UpdateCategoryError'=>[ 'code'=>10000, 'msg'=>'更新文章分类失败','error'=>'UpdateCategoryError' ],
        'UpdateCategoryEventError'=>[ 'code'=>10000, 'msg'=>'更新文章分类事件失败','error'=>'UpdateCategoryEventError' ],
        //移动分类
        'MoveCategoryError'=>[ 'code'=>10000, 'msg'=>'移动文章分类失败','error'=>'MoveCategoryError' ],
        'MoveCategoryEventError'=>[ 'code'=>10000, 'msg'=>'移动文章分类事件失败','error'=>'MoveCategoryEventError' ],
        //删除分类
        'DeleteCategoryError'=>[ 'code'=>10000, 'msg'=>'删除文章分类失败','error'=>'DeleteCategoryError' ],
        'DeleteNoCategoryError'=>[ 'code'=>10000, 'msg'=>'有子分类不允许删除','error'=>'DeleteNoCategoryError' ],
        'DeleteNoArticleCategoryError'=>[ 'code'=>10000, 'msg'=>'有文章具有该分类不允许删除','error'=>'DeleteNoArticleCategoryError' ],
        'DeleteCategoryEventError'=>[ 'code'=>10000, 'msg'=>'删除文章分类事件失败','error'=>'DeleteCategoryEventError' ],

    //|--|--|--标签管理
        'GetLabelError'=>[ 'code'=>10000, 'msg'=>'获取标签失败','error'=>'GetLabelError' ],
        //添加标签
        'AddLabelError'=>[ 'code'=>10000, 'msg'=>'添加标签失败','error'=>'AddLabelError' ],
        'AddLabelEventError'=>[ 'code'=>10000, 'msg'=>'添加标签事件失败','error'=>'AddLabelEventError' ],
        //更新标签
        'UpdateLabelError'=>[ 'code'=>10000, 'msg'=>'更新标签失败','error'=>'UpdateLabelError' ],
        'UpdateLabelEventError'=>[ 'code'=>10000, 'msg'=>'更新标签事件失败','error'=>'UpdateLabelEventError' ],
        //移动标签
        'MoveLabelError'=>[ 'code'=>10000, 'msg'=>'移动标签失败','error'=>'MoveLabelError' ],
        'MoveLabelEventError'=>[ 'code'=>10000, 'msg'=>'移动标签事件失败','error'=>'MoveLabelEventError' ],
        //删除标签
        'DeleteLabelError'=>[ 'code'=>10000, 'msg'=>'删除标签失败','error'=>'DeleteLabelError' ],
        'DeleteNoLabelError'=>[ 'code'=>10000, 'msg'=>'有子标签不允许删除','error'=>'DeleteNoLabelError' ],
        'DeleteNoArticleLabelError'=>[ 'code'=>10000, 'msg'=>'有文章具有该标签不允许删除','error'=>'DeleteNoArticleLabelError' ],
        'DeleteLabelEventError'=>[ 'code'=>10000, 'msg'=>'删除标签事件失败','error'=>'DeleteLabelEventError' ],

    //|--|--级别管理
    //|--|--|--级别条件
        'GetlevelItemError'=>[ 'code'=>10000, 'msg'=>'获取级别配置项失败','error'=>'GetlevelItemError' ],
        //选项级别条件
        'DefaultlevelItemError'=>[ 'code'=>10000, 'msg'=>'默认级别配置项失败','error'=>'DefaultlevelItemError' ],
        'FindlevelItemError'=>[ 'code'=>10000, 'msg'=>'查找级别配置项失败','error'=>'FindlevelItemError' ],
        //添加级别条件
        'AddLevelItemError'=>[ 'code'=>10000, 'msg'=>'添加级别配置项失败','error'=>'AddLevelItemError' ],
        'AddLevelItemEventError'=>[ 'code'=>10000, 'msg'=>'添加级别配置项事件失败','error'=>'AddLevelItemEventError' ],
        //修改级别条件
        'UpdateLevelItemError'=>[ 'code'=>10000, 'msg'=>'更新级别配置项失败','error'=>'UpdateLevelItemError' ],
        'UpdateLevelItemEventError'=>[ 'code'=>10000, 'msg'=>'更新级别配置项事件失败','error'=>'UpdateLevelItemEventError' ],
        //删除级别条件
        'DeleteLevelItemError'=>[ 'code'=>10000, 'msg'=>'删除级别配置项失败','error'=>'DeleteLevelItemError' ],
        'DeleteLevelItemEventError'=>[ 'code'=>10000, 'msg'=>'删除级别配置项事件失败','error'=>'DeleteLevelItemEventError' ],
        //批量删除级别条件
        'MultipleDeleteLevelItemError'=>[ 'code'=>10000, 'msg'=>'批量删除级别配置项失败','error'=>'MultipleDeleteLevelItemError' ],
        'MultipleDeleteLevelItemEventError'=>[ 'code'=>10000, 'msg'=>'批量删除级别配置项事件失败','error'=>'MultipleDeleteLevelItemEventError' ],

    //|--|--|--用户级别
        'GetUserLevelError'=>[ 'code'=>10000, 'msg'=>'获取用户级别失败','error'=>'GetUserLevelError' ],
        //用户级别选项
        'DefaultUserLevelError'=>[ 'code'=>10000, 'msg'=>'默认用户级别失败','error'=>'DefaultUserLevelError' ],
        'FindUserLevelError'=>[ 'code'=>10000, 'msg'=>'查找用户级别失败','error'=>'FindUserLevelError' ],
        //添加
        'AddUserLevelError'=>[ 'code'=>10000, 'msg'=>'添加用户级别失败','error'=>'AddUserLevelError' ],
        'AddUserLevelEventError'=>[ 'code'=>10000, 'msg'=>'添加用户级别事件失败','error'=>'AddUserLevelEventError' ],
        //更新
        'UpdateUserLevelError'=>[ 'code'=>10000, 'msg'=>'更新用户级别失败','error'=>'UpdateUserLevelError' ],
        'UpdateUserLevelEventError'=>[ 'code'=>10000, 'msg'=>'更新用户级别事件失败','error'=>'UpdateUserLevelEventError' ],
        //删除
        'DeleteUserLevelError'=>[ 'code'=>10000, 'msg'=>'删除用户级别失败','error'=>'DeleteUserLevelError' ],
        'DeleteUserLevelEventError'=>[ 'code'=>10000, 'msg'=>'删除用户级别事件失败','error'=>'DeleteUserLevelEventError' ],
        //批量删除
        'MultipleDeleteUserLevelError'=>[ 'code'=>10000, 'msg'=>'批量删除用户级别失败','error'=>'MultipleDeleteUserLevelError' ],
        'MultipleDeleteUserLevelEventError'=>[ 'code'=>10000, 'msg'=>'批量删除用户级别事件失败','error'=>'MultipleDeleteUserLevelEventError' ],
        //用户级别配置项
        'GetUserLevelItemUnionError'=>[ 'code'=>10000, 'msg'=>'获取用户级别配置项失败','error'=>'GetUserLevelItemUnionError' ],
        //添加
        'AddUserLevelItemUnionError'=>[ 'code'=>10000, 'msg'=>'添加用户级别配置项失败','error'=>'AddUserLevelItemUnionError' ],
        'AddUserLevelItemUnionEventError'=>[ 'code'=>10000, 'msg'=>'添加用户级别配置项事件失败','error'=>'AddUserLevelItemUnionEventError' ],
        //修改
        'UpdateUserLevelItemUnionError'=>[ 'code'=>10000, 'msg'=>'更新用户级别配置项失败','error'=>'UpdateUserLevelItemUnionError' ],
        'UpdateUserLevelItemUnionEventError'=>[ 'code'=>10000, 'msg'=>'更新用户级别配置项事件失败','error'=>'UpdateUserLevelItemUnionEventError' ],
        //删除
        'DeleteUserLevelItemUnionError'=>[ 'code'=>10000, 'msg'=>'删除用户级别配置项失败','error'=>'DeleteUserLevelItemUnionError' ],
        'DeleteUserLevelItemUnionEventError'=>[ 'code'=>10000, 'msg'=>'删除用户级别配置项事件失败','error'=>'DeleteUserLevelItemUnionEventError' ],

    //|--|--地区管理
        'GetAllRegionError'=>[ 'code'=>10000, 'msg'=>'获取所有地区失败','error'=>'GetAllRegionError' ],
        'GetTreeRegionError'=>[ 'code'=>10000, 'msg'=>'获取树形地区失败','error'=>'GetTreeRegionError' ],
        //添加
        'AddRegionError'=>[ 'code'=>10000, 'msg'=>'添加地区失败','error'=>'AddRegionError' ],
        'AddRegionEventError'=>[ 'code'=>10000, 'msg'=>'添加地区事件失败','error'=>'AddRegionEventError' ],
        //修改
        'UpdateRegionError'=>[ 'code'=>10000, 'msg'=>'更新地区失败','error'=>'UpdateRegionError' ],
        'UpdateRegionEventError'=>[ 'code'=>10000, 'msg'=>'更新地区事件失败','error'=>'UpdateRegionEventError' ],
        //移动
        'MoveRegionError'=>[ 'code'=>10000, 'msg'=>'移动地区失败','error'=>'MoveRegionError' ],
        'MoveRegionEventError'=>[ 'code'=>10000, 'msg'=>'移动地区事件别失败','error'=>'MoveRegionEventError' ],
        //删除
        'DeleteRegionError'=>[ 'code'=>10000, 'msg'=>'删除地区失败','error'=>'DeleteRegionError' ],
        'DeleteNoRegionError'=>[ 'code'=>10000, 'msg'=>'有子地区不允许删除','error'=>'DeleteNoRegionError' ],
        'DeleteNoUserRegionError'=>[ 'code'=>10000, 'msg'=>'有用户具有该地区不允许删除','error'=>'DeleteNoUserRegionError' ],
        'DeleteRegionEventError'=>[ 'code'=>10000, 'msg'=>'删除地区事件失败','error'=>'DeleteRegionEventError' ],

    //|--|--银行管理
        'GetBankError'=>[ 'code'=>10000, 'msg'=>'获取银行失败','error'=>'GetBankError' ],
        //添加
        'AddBankError'=>[ 'code'=>10000, 'msg'=>'添加银行失败','error'=>'AddBankError' ],
        'AddBankEventError'=>[ 'code'=>10000, 'msg'=>'添加银行事件失败','error'=>'AddBankEventError' ],
        //更新
        'UpdateBankError'=>[ 'code'=>10000, 'msg'=>'更新银行失败','error'=>'UpdateBankError' ],
        'UpdateBankEventError'=>[ 'code'=>10000, 'msg'=>'更新银行事件失败','error'=>'UpdateBankEventError' ],
        //删除
        'DeleteBankError'=>[ 'code'=>10000, 'msg'=>'删除银行失败','error'=>'DeleteBankError' ],
        'DeleteBankEventError'=>[ 'code'=>10000, 'msg'=>'删除银行事件失败','error'=>'DeleteBankEventError' ],
        //批量删除
        'MultipleDeleteBankError'=>[ 'code'=>10000, 'msg'=>'批量删除银行失败','error'=>'MultipleDeleteBankError' ],
        'MultipleDeleteBankEventError'=>[ 'code'=>10000, 'msg'=>'批量删除银行事件失败','error'=>'MultipleDeleteBankEventError' ],

];
