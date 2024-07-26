<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 09:24:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 11:23:48
 * @FilePath: \config\custom\phone\code\phone_pay_code.php
 */

return [

    'PayOrderError'=>['code'=>10000,'msg'=>'订单支付失败','error'=>'PayOrderError'],
    'PayOrderParamsError'=>['code'=>10000,'msg'=>'订单支付参数缺失','error'=>'PayOrderParamsError'],
    'WechatPayOrderByJsNoUserOpenidError'=>['code'=>10000,'msg'=>'微信H5支付的用户openid缺失!','error'=>'WechatPayOrderByJsNoUserOpenidError'],

    //支付回调
    'WechatJsPayNotifyError'=>['code'=>10000,'msg'=>'WechatJsPay回调失败!','error'=>'WechatJsPayNotifyError'],
];
