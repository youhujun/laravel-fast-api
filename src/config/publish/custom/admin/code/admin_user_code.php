<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 01:48:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 20:39:45
 * @FilePath: \config\custom\admin\code\admin_user_code.php
 */

 $adminCodeArray = [

    'GetAdminError'=>[ 'code'=>10000, 'msg'=>'获管理员信息失败','error'=>'GetAdminError' ],
    //添加管理员
    'AddAdminError'=>[ 'code'=>10000, 'msg'=>'添加管理员失败','error'=>'AddAdminError' ],
    'AddAdminUserError'=>[ 'code'=>10000, 'msg'=>'添加管员用户不存在','error'=>'AddAdminUserError' ],
    'AddAdminEventError'=>[ 'code'=>10000, 'msg'=>'添加管理员事件失败','error'=>'AddAdminEventError' ],
    //添加管理员事件
    //管理员角色
    'SelectNoAdminRoleError' => [ 'code'=>10000, 'msg'=>'没有选择管理员角色','error'=>'SelectNoAdminRoleError' ],
    'AddAdminRoleError' => [ 'code'=>10000, 'msg'=>'没有选择管理员角色','error'=>'AddAdminRoleError' ],
    //管理员相册
    'AddAdminAlbumError'=> [ 'code'=>10000, 'msg'=>'添加管理员相册失败','error'=>'AddAdminAlbumError' ],

    //更新管理员
    'UpdateAdminError' =>[ 'code'=>10000, 'msg'=>'更新管理员失败','error'=>'UpdateAdminError' ],
    'SelectNoUserRoleError' =>[ 'code'=>10000, 'msg'=>'未选中用户角色','error'=>'SelectNoUserRoleError' ],
    'UpdateAdminRoleError' =>[ 'code'=>10000, 'msg'=>'更新管理员角色失败','error'=>'UpdateAdminRoleError' ],
    'UpdateAddAdminRoleError' =>[ 'code'=>10000, 'msg'=>'更新时添加管理员角色失败','error'=> 'UpdateAddAdminRoleError'],
    'UpdateAdminEventError' =>[ 'code'=>10000, 'msg'=>'更新管理员事件失败','error'=>'UpdateAdminEventError' ],

    //禁用管理员
    'DisableAdminError'=>[ 'code'=>10000, 'msg'=>'禁用管理员失败','error'=>'DisableAdminError' ],
    'DisableAdminEventError'=>[ 'code'=>10000, 'msg'=>'禁用管理员事件失败','error'=>'DisableAdminEventError' ],
    //批量禁用
    'MultipleDisableAdminError'=>[ 'code'=>10000, 'msg'=>'批量禁用管理员失败','error'=>'MultipleDisableAdminError' ],
    'MultipleDisableSystemAdminError'=>[ 'code'=>10000, 'msg'=>'批量禁用系统管理员','error'=>'MultipleDisableSystemAdminError' ],
    'MultipleDisableAdminEventError'=>[ 'code'=>10000, 'msg'=>'批量禁用管理员事件失败','error'=>'MultipleDisableAdminEventError' ],
    //删除管理员
    'DeleteAdminError'=>[ 'code'=>10000, 'msg'=>'删除管理员失败','error'=>'DeleteAdminError' ],
    'DeleteAdminRoleError'=>[ 'code'=>10000, 'msg'=>'删除管理员角色失败','error'=>'DeleteAdminRoleError' ],
    'DeleteAdminEventError'=>[ 'code'=>10000, 'msg'=>'删除管理员事件失败','error'=>'DeleteAdminEventError' ],
    //批量删除
    'MultipleDeleteAdminError'=>[ 'code'=>10000, 'msg'=>'批量删除管理员失败','error'=>'MultipleDeleteAdminError' ],
    'MultipleDeleteSystemAdminError'=>[ 'code'=>10000, 'msg'=>'批量删除系统管理员','error'=>'MultipleDeleteSystemAdminError' ],
    'MultipleDeleteAdminRoleError'=>[ 'code'=>10000, 'msg'=>'批量删除管理员角色失败','error'=>'MultipleDeleteAdminRoleError' ],
    'MultipleDeleteAdminEventError'=>[ 'code'=>10000, 'msg'=>'批量删除管理员事件失败','error'=>'MultipleDeleteAdminEventError' ],
    //默认管理员
    'GetDefaultAdminError' => [ 'code'=>0, 'msg'=>'获取默认管理员失败','error'=>'GetDefaultAdminError' ],
    'FindAdminError' =>[ 'code'=>10000, 'msg'=>'查找管理员失败!','error'=>'FindAdminError' ],
 ];


 $userCodeArray =  [
    //|--|--|--用户管理
        //用户管理
        'GetUserError'=>[ 'code'=>10000, 'msg'=>'获取用户失败','error'=>'GetUserError' ],
        'DisableUserError'=>[ 'code'=>10000, 'msg'=>'用户被禁用','error'=>'DisableUserError' ],
        //添加
        'AddUserError'=>[ 'code'=>10000, 'msg'=>'添加用户失败','error'=>'AddUserError' ],
        'AddUserEventError'=>[ 'code'=>10000, 'msg'=>'添加用户事件失败','error'=>'AddUserEventError' ],
        //详情
        'AddUserInfoError'=>[ 'code'=>10000, 'msg'=>'添加用户详情失败','error'=>'AddUserInfoError' ],
        //用户相册
        'AddUserAlbumError'=>[ 'code'=>10000, 'msg'=>'添加用户相册成功','error'=>'AddUserAlbumError' ],
        //用户头像
        'AddUserAvatarError'=>[ 'code'=>10000, 'msg'=>'添加用户头像失败','error'=>'AddUserAvatarError' ],
        //用户角色
        'AddUserRoleError' =>[ 'code'=>10000, 'msg'=>'添加用户角色失败','error'=>'AddUserRoleError'],
        //用户二维码
        'FindUserAlbumError'=>[ 'code'=>10000, 'msg'=>'查找用户相册失败' ,'error'=>'FindUserAlbumError'],
        'SaveUserQrcodeError'=>[ 'code'=>10000, 'msg'=>'保存用户二维码失败','error'=>'SaveUserQrcodeError' ],
        'AddUserQrcodeError'=>[ 'code'=>10000, 'msg'=>'添加用户二维码失败','error'=>'AddUserQrcodeError' ],
        //删除用户
        'DeleteUserError'=>[ 'code'=>10000, 'msg'=>'删除用户失败','error'=>'DeleteUserError' ],
        'DeleteSystemUserError'=>[ 'code'=>10000, 'msg'=>'删除系统用户失败','error'=>'DeleteSystemUserError' ],
        'DeleteUserEventError'=>[ 'code'=>10000, 'msg'=>'删除用户事件失败','error'=>'DeleteUserEventError' ],
        //禁用系统用户
        'DisableUserError'=>[ 'code'=>10000, 'msg'=>'禁用用户失败','error'=>'DisableUserError' ],
        'DisableSystemUserError'=>[ 'code'=>10000, 'msg'=>'禁用系统用户失败','error'=>'DisableSystemUserError' ],
        'DisableUserEventError'=>[ 'code'=>10000, 'msg'=>'禁用用户事件失败','error'=>'DisableUserEventError' ],
        //批量删除 'multipleDeleteUserSuccess'=>[ 'code'=>0, 'msg'=>'批量删除用户成功' ],
        'MultipleDeleteUserError'=>[ 'code'=>10000, 'msg'=>'批量删除用户失败','error'=>'MultipleDeleteUserError' ],
        'MultipleDeleteSystemUserError'=>[ 'code'=>10000, 'msg'=>'批量删除系统用户','error'=>'MultipleDeleteSystemUserError' ],
        'MultipleDeleteUserEventError'=>[ 'code'=>10000, 'msg'=>'批量删除用户事件失败','error'=>'MultipleDeleteUserEventError' ],
        //批量禁用
        'MultipleDisableUserError'=>[ 'code'=>10000, 'msg'=>'批量禁用用户失败','error'=>'MultipleDisableUserError' ],
        'MultipleDisableSystemUserError'=>[ 'code'=>10000, 'msg'=>'批量禁用系统用户','error'=>'MultipleDisableSystemUserError' ],
        'MultipleDisableUserEventError'=>[ 'code'=>10000, 'msg'=>'批量禁用用户事件失败','error'=>'MultipleDisableUserEventError' ],

    //|--|--|--|++ 用户实名认证
        'GetUserRealAuthApplyError' =>[ 'code'=>10000, 'msg'=>'获取实名认证用户申请失败!','error'=>'GetUserRealAuthApplyError' ],
        //认证用户
        'RealAuthUserError'=>[ 'code'=>10000, 'msg'=>'实名认证用户失败','error'=>'RealAuthUserError' ],
        'RealAuthEventError'=>[ 'code'=>10000, 'msg'=>'实名认证用户事件失败','error'=>'RealAuthEventError' ],
        //认证用户事件
        'RealAuthApplyHasError'=>[ 'code'=>10000, 'msg'=>'实名认证用户已经审核过!','error'=>'RealAuthApplyHasError' ],
        'RealAuthApplyError' => [ 'code'=>10000, 'msg'=>'实名认证用户申请失败','error'=>'RealAuthApplyError' ],
        'ThisUserHasRealAuthError'=> ['code'=>10000, 'msg'=>'已经有实名认证正在申请中','error'=>'ThisUserHasRealAuthError'],
        //用户身份证号
        'UpdateUserIdNumberError' => [ 'code' => 10000, 'msg' => '更新用户身份证号失败','error'=>'UpdateUserIdNumberError' ],
        'UpdateUserIdNumberEventError' => [ 'code' => 10000, 'msg' => '更新用户身份证号事件失败','error'=>'UpdateUserIdNumberEventError' ],
        //获取身份证
        'GetUserIdCardError' =>[ 'code' => 10000, 'msg' => '获取用户身份证号失败','error'=>'GetUserIdCardError' ],
        //后台设置用户身份证
        'SetUserIdCardError' => [ 'code' => 10000, 'msg' => '设置用户身份证号失败','error'=>'SetUserIdCardError' ],
        'SetUserIdCardEventError' => [ 'code' => 10000, 'msg' => '设置用户身份证号失败','error'=>'SetUserIdCardEventError' ],
        //设置用户身份证事件
        'ThisUserIsRealAuthError' => [ 'code' => 10000, 'msg' => '该用户身份已经实名审核','error'=>'ThisUserIsRealAuthError' ],
        ',ThisUserHasRealAuthError' => [ 'code' => 10000, 'msg' => '该用户身份已经申请实名审核','error'=>'ThisUserHasRealAuthError' ],
        'SetUserApplyRealAuthError' => [ 'code' => 10000, 'msg' => '设置用户实名认证申请失败' ,'error'=>'SetUserApplyRealAuthError'],

    //|--|--|--|++ 用户选项
        //默认用户选项
        'GetDefaultUserError' => [ 'code'=>10000, 'msg'=>'获取用户选项失败','error'=>'GetDefaultUserError' ],
        //查找用户选项
        'FindUserError' => [ 'code'=>10000, 'msg'=>'查找用户选项失败','error'=>'FindUserError' ],
    //|--|--|--用户详情
        //用户手机号
        'UpdateUserPhoneError' => [ 'code' => 10000, 'msg' => '更新用户手机号失败','error'=>'UpdateUserPhoneError' ],
        'UpdateUserPhoneEventError' => [ 'code' => 10000, 'msg' => '更新用户手机号事件失败','error'=>'UpdateUserPhoneEventError' ],
        //用户真是姓名
        'UpdateUserRealNameError' => [ 'code' => 10000, 'msg' => '更新用户真实姓名失败','error'=>'UpdateUserRealNameError' ],
        'UpdateUserRealNameEventError' => [ 'code' => 10000, 'msg' => '更新用户真实姓名事件失败','error'=>'UpdateUserRealNameEventError' ],
        //用户昵称
        'UpdateUserNickNameError' => [ 'code' => 10000, 'msg' => '更新用户昵称失败','error'=>'UpdateUserNickNameError' ],
        'UpdateUserNickNameEventError' => [ 'code' => 10000, 'msg' => '更新用户昵称事件失败','error'=>'UpdateUserNickNameEventError' ],
        //用户性别
        'UpdateUserSexError' => [ 'code' => 10000, 'msg' => '更新用户性别失败','error'=>'UpdateUserSexError' ],
        'UpdateUserSexEventError' => [ 'code' => 10000, 'msg' => '更新用户性别事件失败','error'=>'UpdateUserSexEventError' ],
        //用户级别
        'ChangeUserLevelError'  => [ 'code' => 10000, 'msg' => '更该用户级别失败','error'=>'ChangeUserLevelError' ],
        'ChangeUserLevelEventError' => [ 'code' => 10000, 'msg' => '更该用户级别事件失败','error'=>'ChangeUserLevelEventError' ],
        //用户生日
        'UpdateUserBirthdayTimeError' => [ 'code' => 10000, 'msg' => '更新用户生日失败','error'=>'UpdateUserBirthdayTimeError' ],
        'UpdateUserBirthdayTimeEventError' => [ 'code' => 10000, 'msg' => '更新用户生日事件失败','error'=>'UpdateUserBirthdayTimeEventError' ],
        //重置用户密码
        'ResetUserPasswordError' => [ 'code' => 10000, 'msg' => '重置用户密码失败','error'=>'ResetUserPasswordError' ],
        'ResetUserPasswordEventError' => [ 'code' => 10000, 'msg' => '重置用户密码失败','error'=>'ResetUserPasswordEventError' ],

    //|--|--|--用户地址
        //用户地址--添加
        'AddUserAddressError' => [ 'code' => 10000, 'msg' => '添加用户地址失败','error'=>'AddUserAddressError' ],
        'AddUserAddressEventError' => [ 'code' => 10000, 'msg' => '添加用户地址事件失败','error'=>'AddUserAddressEventError' ],
        'AddUserAddressSetDefaultError' => [ 'code' => 10000, 'msg' => '添加用户地址设置默认失败','error'=>'AddUserAddressSetDefaultError' ],
        //用户地址--获取
        'GetUserAddressError'=> [ 'code' => 10000, 'msg' => '获取用户地址失败','error'=>'GetUserAddressError' ],
        //用户地址--删除
        'DeleteUserAddressError'=> [ 'code' => 10000, 'msg' => '删除用户地址失败','error'=>'DeleteUserAddressError' ],
        'DeleteUserAddressEventError'=> [ 'code' => 10000, 'msg' => '删除用户地址事件失败','error'=>'DeleteUserAddressEventError' ],
        //用户地址--设置默认
        'SetDefaultUserAddressError'=> [ 'code' => 10000, 'msg' => '设置默认用户地址失败','error'=>'SetDefaultUserAddressError' ],
        'SetDefaultUserAddressEventError'=> [ 'code' => 10000, 'msg' => '设置默认用户地址事件失败','error'=>'SetDefaultUserAddressEventError' ],
        'SetDefaultUserAddressOtherError'=> [ 'code' => 10000, 'msg' => '设置默认用户地址其他失败','error'=>'SetDefaultUserAddressOtherError' ],

    //|--|--|--用户银行卡
        'AddUserBankError' => [ 'code' => 10000, 'msg' => '添加用户银行卡失败','error'=>'AddUserBankError' ],
        'AddUserBankEventError' => [ 'code' => 10000, 'msg' => '添加用户银行卡事件失败','error'=>'AddUserBankEventError' ],
        'AddUserBankSetDefaultError' => [ 'code' => 10000, 'msg' => '添加用户银行卡设置默认失败','error'=>'AddUserBankSetDefaultError' ],
        //用户银行卡--获取
        'GetUserBankError'=> [ 'code' => 10000, 'msg' => '获取用户银行卡失败','error'=>'GetUserBankError' ],
        //用户银行卡--删除
        'DeleteUserBankError'=> [ 'code' => 10000, 'msg' => '删除用户银行卡失败','error'=>'DeleteUserBankError' ],
        'DeleteUserBankEventError'=> [ 'code' => 10000, 'msg' => '删除用户银行卡事件失败','error'=>'DeleteUserBankEventError' ],
        //用户银行卡--设置默认
        'SetDefaultUserBankError'=> [ 'code' => 10000, 'msg' => '设置默认用户银行卡失败','error'=>'SetDefaultUserBankError' ],
        'SetDefaultUserBankEventError'=> [ 'code' => 10000, 'msg' => '设置默认用户银行卡事件失败','error'=>'SetDefaultUserBankEventError' ],
        'SetDefaultUserBankOtherError'=> [ 'code' => 10000, 'msg' => '设置默认用户银行卡其他失败','error'=>'SetDefaultUserBankOtherError' ],
    //|--|--|++用户团队
        //用户推荐人 上级
        'GetUserRecommendError' => [ 'code' => 10000, 'msg' => '获取用户上级推荐人失败','error'=>'GetUserRecommendError' ],
        //用户下级
        'GetUserLowerTeamError' => [ 'code' => 0, 'msg' => '获取用户下级团队失败','error'=>'GetUserLowerTeamError' ],
        //|--|--|++用户金额
        'SetUserAccountError' => [ 'code' => 10000, 'msg' => '修改用户账户金额失败','error'=>'SetUserAccountError' ],
        'SetUserAccountEventError' => [ 'code' => 10000, 'msg' => '修改用户账户金额事件失败' ,'error'=>'SetUserAccountEventError'],
        'SetUserAccountActionTypeError' => [ 'code' => 10000, 'msg' => '修改用户账户操作类型不正确','error'=>'SetUserAccountActionTypeError' ],
        'SetUserAccountTypeError' => [ 'code' => 10000, 'msg' => '修改用户账户类型不正确','error'=>'SetUserAccountTypeError' ],
        'SetUserAccountNotEnoughError' => [ 'code' => 10000, 'msg' => '修改用户账户余额不足' ,'error'=>'SetUserAccountNotEnoughError'],
        //后台用户账户事件
        'SetUserAccountLogError' => [ 'code' => 10000, 'msg' => '记录用户账户日志失败','error'=>'
        SetUserAccountLogError'],
        //查看用户余额日志
        'GetUserAccountLogError' => [ 'code' => 10000, 'msg' => '获取用户账户日志失败','error'=>'
        GetUserAccountLogError' ],

    //|--|--|--管理员管理

];


$totalCodeArray = array_merge($adminCodeArray,$userCodeArray);

return $totalCodeArray;
