<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-28 19:16:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-29 07:43:38
 * @FilePath: \config\custom\public\code\common_sms_code.php
 */

return [

    'TencentSecretIdError'=>['code'=>10000,'msg'=>'腾讯云SecretId丢失','error'=>'TencentSecretIdError'],
    'TencentSecretKeyError'=>['code'=>10000,'msg'=>'腾讯云SecretKey丢失','error'=>'TencentSecretKeyError'],

    'TencentSmsApConfigError'=>['code'=>10000,'msg'=>'腾讯云短信地域配置丢失','error'=>'TencentSecretKeyError'],
    'TencentSmsSdkAppIdError'=>['code'=>10000,'msg'=>'腾讯云短信AppId丢失','error'=>'TencentSmsSdkAppIdError'],
    'TencentSmsSignNameError'=>['code'=>10000,'msg'=>'腾讯云短信签名丢失','error'=>'TencentSmsSignNameError'],
    'TencentSmsTemplateIdError'=>['code'=>10000,'msg'=>'腾讯云短信模版Id丢失','error'=>'TencentSmsTemplateIdError'],
    'TencentSmsPhonePreError'=>['code'=>10000,'msg'=>'腾讯云短信前缀错误','error'=>'TencentSmsTemplateIdError'],
    'TencentSmsContentError'=>['code'=>10000,'msg'=>'腾讯云短信内容错误','error'=>'TencentSmsContentError'],
    'TencentSmsPhoneNumberError'=>['code'=>10000,'msg'=>'腾讯云短信手机号错误','error'=>'TencentSmsPhoneNumberError'],

    'TencentSmsError'=>['code'=>10000,'msg'=>'腾讯云发送短信异常','error'=>'TencentSmsError'],
    'TencentSmsSendError'=>['code'=>10000,'msg'=>'腾讯云发送短信异常','error'=>'TencentSmsSendError'],
    'SmsCodeSendError'=>['code'=>10000,'msg'=>'短信验证码发送失败','error'=>'SmsCodeSendError'],

];
