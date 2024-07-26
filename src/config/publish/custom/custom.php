<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-30 20:05:13
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-11-07 14:21:53
 */

 return [

     /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    |
    | This value is the verson of your application.
    |
    */

    //定义项目版本号
    'version' => env('APP_VERSION', 'v1'),

    //组件包是发布运行在项目中还是 直接在组件包运行
    'publish' => env('YOUHUJUN_PUBLISH', false),
    //组件包项目是否运行
    'runing' => env('YOUHUJUN_RUNING', false),
    //app_name 默认为YouHu
	//目前用来判断数据填充
	'app_name'=>env('APP_NAME','YouHu'),
    //websocket 端口号
	'websocket_port'=>env('WEBSOCKET_PORT',9001),
 ];
