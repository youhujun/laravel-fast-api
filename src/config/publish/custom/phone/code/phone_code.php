<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-05-04 16:43:47
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-11 09:31:30
 */
//|--手机端
//超级定义
$superCodeArray = [
    //服务器异常错误  这种情况下是调用公共异常没有传入错误码
    'ServerError'=>[ 'code'=>50000, 'msg'=>'服务器异常错误!','error'=>'ServerError' ],
    'CodeError'=>[ 'code'=>51010, 'msg'=>'错误码不存!','error'=>'CodeError' ],
];
//手机系统
$phoneCodeArray = [
     //发送异常邮件通知定义
    'EmailArray' => [
        //'serverError',
    ],

    //权限失败
    'PhoneAuthError'=>[ 'code'=>10000, 'msg'=>'您不具有操作权限!','error'=>'PhoneAuthError'],

     //中间件验证失败
    'PhoneTokenError' => ['code' =>60030, 'msg' => '无效的token,请重新登录','error'=>'PhoneTokenError'],

    //请求参数为空
    'ParamsIsNullError'=>[ 'code'=>10000, 'msg'=>'请求参数为空!','error'=>'ParamsIsNullError'],

    'ThisDataNotExistsError' => ['code' =>10000,'msg'=>'该数据不存在!','error'=>'ThisDataNotExistsError'],

];

$errorCodeArray = array_merge(
    $superCodeArray,
    $phoneCodeArray,
);

 return $errorCodeArray;
