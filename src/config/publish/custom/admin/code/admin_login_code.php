<?php

return [
    //登录
    'AdminLoginError'=>[ 'code'=>10000, 'msg'=>'登录失败!','error'=>'AdminLoginError'],
    'GetLoginAdminError'=>[ 'code'=>10000, 'msg'=>'获取登录管理员失败!','error'=>'GetLoginAdminError'],
    'RedisAddAdminError'=>[ 'code'=>10000, 'msg'=>'redis管理员添加失败','error'=>'RedisAddAdminError'],
    'AdminLoginLogError'=>[ 'code'=>10000, 'msg'=>'管理员登录日志添加失败','error'=>'AdminLoginLogError'],
    'CacheAdminRolesError'=>[ 'code'=>10000, 'msg'=>'缓存管理员角色失败','error'=>'CacheAdminRolesError'],
    'AdminLogoutJobError'=>[ 'code'=>10000, 'msg'=>'管理员登退出任务失败','error'=>'AdminLogoutJobError'],

    //退出
    'AdminLogoutError'=>[ 'code'=>10000, 'msg'=>'管理员登退出失败','error'=>'AdminLogoutError'],
    'AdminLogoutLogError'=>[ 'code'=>10000, 'msg'=>'管理员登退出日志添加失败','error'=>'AdminLogoutLogError'],
];
