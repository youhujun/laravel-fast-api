<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-05-04 23:46:31
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-15 19:20:56
 */

$userCodeArray = [
    'UserRealAuthApply' => ['code'=>10000,'info'=>'用户申请实名认证','event'=>'UserRealAuthApply'],
];
$totalCodeArray =  [

     //用户
    'AddUser'=>['code'=>10000,'info'=>'用户注册','event'=>'AddUser'],
    'WechatOfficialAddUser'=>['code'=>10000,'info'=>'微信公众号用户注册','event'=>'WechatOfficialAddUser'],
    'AddUserByUniverify'=>['code'=>10000,'info'=>'一键登录注册用户','event'=>'AddUserByUniverify'],
    'UserLogin'=>['code'=>10000,'info'=>'用户登录','event'=>'UserLogin'],
    'UserLogout'=>['code'=>10000,'info'=>'用户退出','event'=>'UserLogout'],

];

$eventCodeArray = array_merge(
    $userCodeArray,
    $totalCodeArray
);

 return $eventCodeArray;
