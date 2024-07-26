<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-10-08 12:51:22
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 11:17:48
 */

$systemCodeArray =  [

 ];
//开发者
$developCodeArray = [
     //开发者
    'AddDeveloper' =>  [ 'code' => 10000, 'info' => '添加后台开发者','event'=>'AddDeveloper' ],
];

//|--日志管理
$logCodeArray = [
    'DeleteAdminLoginLog' => [ 'code' => 10000, 'info' => '删除管理员登录日志','event'=>'DeleteAdminLoginLog' ],
    'MultipleDeleteAdminLoginLog'=> [ 'code' => 10000, 'info' => '批量删除后台管理员日志','event'=>'MultipleDeleteAdminLoginLog' ],

    'DeleteUserLoginLog' =>[ 'code' => 10000, 'info' => '删除用户登录日志','event'=>'DeleteUserLoginLog' ],
    'MultipleDeleteUserLoginLog' =>[ 'code' => 10000, 'info' => '批量删除用户登录日志','event'=>'MultipleDeleteUserLoginLog' ],
];

$eventCodeArray = array_merge(
    $systemCodeArray,
    $developCodeArray,
    $logCodeArray,
);

return $eventCodeArray;
