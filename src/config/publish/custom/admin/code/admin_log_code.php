<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 01:51:34
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 01:54:11
 * @FilePath: \config\custom\admin\code\admin_log_code.php
 */

return [
    //|--|--后台登录日志
        //删除管理员登录日志
        'DeleteAdminLoginLogError'=>[ 'code'=>10000, 'msg'=>'删除管理员登录日志失败','error'=>'DeleteAdminLoginLogError' ],
        'DeleteAdminLoginLogEventError'=>[ 'code'=>10000, 'msg'=>'删除管理员登录日志事件失败','error'=>'DeleteAdminLoginLogEventError' ],
        //批量删除
        'MultipleDeleteAdminLoginLogError'=>[ 'code'=>10000, 'msg'=>'批量删除管理员登录日志失败','error'=>'MultipleDeleteAdminLoginLogError' ],
        'MultipleDeleteAdminLoginLogError'=>[ 'code'=>10000, 'msg'=>'批量删除管理员登录日志事件失败','error'=>'MultipleDeleteAdminLoginLogError' ],
    //|--|--手机登录日志
        'GetUserLoginLogError'=> ['code'=>10000,'msg'=>'获取用户登录日志失败','error'=>'GetUserLoginLogError'],
         //删除登录日志
        'DeleteUserLoginLogError'=>['code'=>10000,'msg'=>'删除用户登录日志失败','error'=>'DeleteUserLoginLogError'],
        'DeleteUserLoginLogEventError'=>['code'=>10000,'msg'=>'删除用户登录日志事件失败','error'=>'DeleteUserLoginLogEventError'],
         //批量删除
        'MultipleDeleteUserLoginLogError'=>[ 'code'=>10000, 'msg'=>'批量删除用户登录日志失败','error'=>'MultipleDeleteUserLoginLogError' ],
        'MultipleDeleteUserLoginLogError'=>[ 'code'=>10000, 'msg'=>'批量删除用户登录日志事件失败','error'=>'MultipleDeleteUserLoginLogError' ],

        //事件日志
        'EventLogError'=>[ 'code'=>10000, 'msg'=>'获取事件日志失败','error'=>'EventLogError' ],
        'DeleteEventLogError'=>[ 'code'=>10000, 'msg'=>'删除事件日志失败','error'=>'DeleteEventLogError' ],
        'MultipleDeleteEventLogError'=>[ 'code'=>10000, 'msg'=>'批量删除事件日志失败','error'=>'MultipleDeleteEventLogError' ],
];
