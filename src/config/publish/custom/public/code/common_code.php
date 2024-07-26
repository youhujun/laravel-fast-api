<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:33:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-18 09:59:58
 * @FilePath: \config\custom\public\code\common_code.php
 */
//|--公共服务
//超级定义
$superCodeArray = [
    //服务器异常错误  这种情况下是调用公共异常没有传入错误码
    'ServerError'=>[ 'code'=>50000, 'msg'=>'服务器异常错误!' ],
    'CodeError'=>[ 'code'=>51010, 'msg'=>'错误码不存!' ],
];

$totalCodeArray =  [

    //发送异常邮件通知定义
    'EmailArray' =>[
        //'serverError',
    ],

     //超时中间件验证失败1
    'TimeError'=>[ 'code'=>90010, 'msg'=>'请求超时','error'=>'TimeError' ],
     //限流中间件验证失败 以及服务提供者1
    'ThrottleError'=>[ 'code'=>90020, 'msg'=>'超过请求频率','error'=>'ThrottleError'],

    //excel表格
    'ExportExcelInItError'=>[ 'code'=>10000, 'msg'=>'excel表格初始化错误!','error'=>'ExportExcelInItError'],
    //二维码
    'QrcodeNotExistLogo'=>[ 'code'=>10000, 'msg'=>'二维码没有logo','error'=>'QrcodeNotExistLogo'],
    'MakeUserQrcodeError'=>[ 'code'=>10000, 'msg'=>'生成用户二维码失败','error'=>'MakeUserQrcodeError'],

    //********************************第三方服务******************************** */

   //七牛云
   'QiNiuAccessKeyError'=>[ 'code'=>10000, 'msg'=>'七牛云AccessKey缺失!','error'=>'QiNiuAccessKeyError'],
   'QiNiuSecretKeyError'=>[ 'code'=>10000, 'msg'=>'七牛云SecretKey缺失!','error'=>'QiNiuSecretKeyError'],
   'QiNiuDefaultBucketError'=>[ 'code'=>10000, 'msg'=>'七牛云默认存储空间缺失!','error'=>'QiNiuDefaultBucketError'],
   'QiNiuCdnUrlError'=>[ 'code'=>10000, 'msg'=>'七牛云cdnUrl缺失!','error'=>'QiNiuCdnUrlError']
];

//|--支付回调应答
//注意微信官方规定的应答格式如下
$notifyCodeArray = [
    //微信JsPayNotify
    'JsPayNotifySuccess' => ['code'=>'SUCCESS' ,'message'=>'处理支付回调成功!'],
    'JsPayNotifyError' => ['code'=>'FAIL' ,'message'=>'处理支付回调失败'],
    'JsPayNotifyNoOrderError' => ['code'=>'FAIL' ,'message'=>'没有订单数据'],
    'JsPayNotifyUpdateOrderError' => ['code'=>'FAIL' ,'message'=>'修改订单状态失败'],
    'JsPayNotifyEventError' => ['code'=>'FAIL' ,'message'=>'记录回调事件失败'],
];

$errorCodeArray = array_merge(
    $superCodeArray,
    $totalCodeArray,
    $notifyCodeArray
);

return $errorCodeArray;
