<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 02:07:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 15:18:29
 * @FilePath: \config\custom\admin\event\admin_user_event.php
 */
$adminCodeArray = [
     //|--|--管理员管理
    'AddAdmin' => [ 'code' => 10000, 'info' => '添加管理员','event'=>'AddAdmin' ],
    'UpdateAdmin' => [ 'code' => 10000, 'info' => '修改管理员','event'=>'UpdateAdmin' ],
    'DisableAdmin' => [ 'code' => 10000, 'info' => '禁用管理员','event'=>'DisableAdmin' ],
    'DeleteAdmin' => [ 'code' => 10000, 'info' => '删除管理员','event'=>'DeleteAdmin' ],
    'MultipleDisableAdmin' => [ 'code' => 10000, 'info' => '批量禁用管理员','event'=>'MultipleDisableAdmin' ],
    'MultipleDeleteAdmin' => [ 'code' => 10000, 'info' => '批量删除管理员','event'=>'MultipleDeleteAdmin' ],
];

$userCodeArray = [

     //|--|--用户管理
        'AddUser' => [ 'code' => 10000, 'info' => '添加用户','event'=>'AddUser' ],
        'DisableUser' => [ 'code' => 10000, 'info' => '禁用用户','event'=>'DisableUser' ],
        'MultipleDisableUser' => [ 'code' => 10000, 'info' => '批量禁用用户','event'=>'MultipleDisableUser'],
        'DeleteUser' => [ 'code' => 10000, 'info' => '删除用户','event'=>'DeleteUser' ],
        'MultipleDeleteUser' => [ 'code' => 10000, 'info' => '批量删除用户','event'=>'MultipleDeleteUser'],
        //|--|--|++用户实名认证
        'RealAuthUser' => [ 'code' => 10000, 'info' => '审核实名认证用户','event'=>'RealAuthUser' ],
        'UpdateUserIdNumber'=>[ 'code' => 10000, 'info' => '更新用户身份证号','event'=>'UpdateUserIdNumber' ],
        'SetUserIdCard' => [ 'code' => 10000, 'info' => '设置用户身份证','event'=>'SetUserIdCard' ],
        //|--|--|++用户详情
        //用户手机号
        'UpdateUserPhone'=>[ 'code' => 10000, 'info' => '更新用户手机号','event'=>'UpdateUserPhone' ],
        //用户真实姓名
        'UpdateUserRealName'=>[ 'code' => 10000, 'info' => '更新用户真实姓名' ,'event'=>'UpdateUserRealName'],
        //用户昵称
        'UpdateUserNickName'=>[ 'code' => 10000, 'info' => '更新用户昵称','event'=>'UpdateUserNickName' ],
        //用户性别
        'UpdateUserSex'=>[ 'code' => 10000, 'info' => '更新用户性别','event'=>'UpdateUserSex' ],
        //用户级别
        'ChangeUserLevel' => [ 'code' => 10000, 'info' => '改变用户级别','event'=>'ChangeUserLevel' ],
        //用户生日
        'UpdateUserBirthdayTime'=>[ 'code' => 10000, 'info' => '更新用户生日','event'=>'UpdateUserBirthdayTime' ],
        //用户密码
        'ResetUserPassword' => [ 'code' => 10000, 'info' => '重置用户密码','event'=>'ResetUserPassword' ],
        //|--|--|++用户地址
        'AddUserAddress' => [ 'code' => 10000, 'info' => '添加用户地址' ,'event'=>'AddUserAddress'],
        'DeleteUserAddress' => [ 'code' => 10000, 'info' => '删除用户地址' ,'event'=>'DeleteUserAddress'],
        'SetDefaultUserAddress' => [ 'code' => 10000, 'info' => '设置用户默认地址','event'=>'SetDefaultUserAddress' ],
        //|--|--|++用户银行卡
        'AddUserBank' => [ 'code' => 10000, 'info' => '添加用户银行卡','event'=>'AddUserBank' ],
        'SetDefaultUserBank' => [ 'code' => 10000, 'info' => '设置用户银默认银行卡','event'=>'SetDefaultUserBank' ],
        'DeleteUserBank' => [ 'code' => 10000, 'info' => '删除用户银行卡','event'=>'DeleteUserBank' ],
        //|--|--|++用户账户
        'SetUserAccount' => [ 'code' => 10000, 'info' => '后台修改用户金额','event'=>'
        SetUserAccount' ],
];

$totalCodeArray = array_merge($adminCodeArray,$userCodeArray);

return $totalCodeArray;
