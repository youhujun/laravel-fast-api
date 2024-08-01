<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-15 11:03:09
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-08-01 12:30:41
 * @FilePath: \config\custom\phone\event\phone_user_event.php
 */

return [
	//清理缓存
    'ClearUserCache'=>['code'=>10000,'info'=>'用户清理缓存','event'=>'ClearUserCache'],

	//绑定手机号
    'UserBindPhone'=>['code'=>10000,'info'=>'用户绑定手机号','event'=>'UserBindPhone'],

	//重置手机密码
    'RestPasswordByPhone'=>['code'=>10000,'info'=>'重置手机密码','event'=>'RestPasswordByPhone'],
];
