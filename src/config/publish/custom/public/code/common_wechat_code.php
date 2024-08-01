<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-07 19:20:24
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-08-01 11:19:27
 * @FilePath: \config\custom\public\code\common_wechat_code.php
 */

return [
    //微信公众号
    'WechatOfficialAppIdError'=>['code'=>10000,'msg'=>'微信公众号AppIdError','error'=>'WechatOfficialAppIdError'],
    'WecahtOfficialAppSercetError'=>['code'=>10000,'msg'=>'微信公众号AppSercetError','error'=>'WecahtOfficialAppSercetError'],
    'WechatOfficialAuthRedirectUrlError'=>['code'=>10000,'msg'=>'微信公众号AuthRedirectUrlError','error'=>'WechatOfficialAuthRedirectUrlError'],

    'WechatOfficialGetCodeError'=>['code'=>10000,'msg'=>'微信公众号发起授权失败','error'=>'WechatOfficialGetCodeError'],
    'WechatOfficialAuthError'=>['code'=>10000,'msg'=>'微信公众号授权失败','error'=>'WechatOfficialAuthError'],

    'WechatOfficialAddUserError'=>['code'=>10000,'msg'=>'微信公众号注册用户失败','error'=>'WechatOfficialAddUserError'],

    'RedisAddUserError'=>['code'=>10000,'msg'=>'Redis用户登录失败!','error'=>'RedisAddUserError'],

    //微信支付
    'WechatMerchantMerchantIdError'=>['code'=>10000,'msg'=>'微信商户Id不存在!','error'=>'WechatMerchantMerchantIdError'],
    'WechatMerchantMerchantSerialNumberError'=>['code'=>10000,'msg'=>'微信商户API证书序列号不存在!','error'=>'WechatMerchantMerchantSerialNumberError'],
    'WechatMerchantMerchantPrivateKeyError'=>['code'=>10000,'msg'=>'微信商户私钥不存在!','error'=>'WechatMerchantMerchantPrivateKeyError'],
    'WechatMerchantWechatpayCertificateError'=>['code'=>10000,'msg'=>'微信商户平台证书不存在!','error'=>'WechatMerchantWechatpayCertificateError'],
    'WecahtMerchantNotifyUrlJsPayNotifyUrlError'=>['code'=>10000,'msg'=>'微信Js支付回调链接不存在!','error'=>'WecahtMerchantNotifyUrlJsPayNotifyUrlError'],

    'PrePayOrderByWechatJsError'=>['code'=>10000,'msg'=>'微信支付订单不存在!','error'=>'PrePayOrderByWechatJsError'],

    //微信支付解密
    'WechatApiV3KKeyNotExistsError'=>['code'=>10000,'msg'=>'微信支付的ApiV3Key不存在!','error'=>'WechatApiV3KKeyNotExistsError'],

	//微信查找用户不存在
    'WechatOfficialFindUserError'=>['code'=>10000,'msg'=>'微信查找用户不存在!','error'=>'WechatOfficialFindUserError'],

	

];
