<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-27 10:52:52
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-10 09:29:32
 * @FilePath: \config\custom\phone\code\phone_login_code.php
 */

return [
    'LoginPhoneError'=> ['code' => 10000, 'msg' => '登录手机号错误!!','error'=>'LoginPhoneError'],
    //手机号密码登录
    'LoginByUserError' => ['code' => 10000, 'msg' => '用户密码登录错误!','error'=>'loginByUserError'],
    'LoginByPhoneError' => ['code' => 10000, 'msg' => '用户手机号登录错误!','error'=>'LoginByPhoneError'],
    'LoginPhoneError'=> ['code' => 10000, 'msg' => '登录失败','error'=>'LoginPhoneError'],
    'RedisAddUserError'=> ['code' => 10000, 'msg' => '用户添加redis失败','error'=>'RedisAddUserError'],
    'AddPhoneUserLoginLogError'=> ['code' => 10000, 'msg' => '添加用户登录日志失败','error'=>'AddPhoneUserLoginLogError'],
    //获取用户信息
    'GetUserInfoError' => ['code' => 10000, 'msg' => '获取用户信息失败!','error'=>'GetUserInfoError'],

    //发送手机验证码错误
    'SendPhoneCodeError' => ['code' => 10000, 'msg' => '发送手机验证码错误!','error'=>'SendPhoneCodeError'],
    'SmsInitError' => ['code' => 10000, 'msg' => '短信验证码初始化失败!','error'=>'SmsInitError'],
    'SmsCodeSaveError'=>['code' => 10000, 'msg' => '短信验证码redis存储失败!','error'=>'SmsCodeSaveError'],

    //短信验证码发送失败
    'SmsCodeSendError'=>['code'=>10000,'msg'=>'短信验证码发送失败','error'=>'SmsCodeSendError'],
    'TencentSmsTemplateIdError'=>['code'=>10000,'msg'=>'腾讯云短信模版Id丢失','error'=>'TencentSmsTemplateIdError'],

    //手机号验证码错误
    'LoginByPhoneError'=>['code' => 10000, 'msg' => '手机号验证码错误!','error'=>'LoginByPhoneError'],
    //手机号验证码错误
    'PhoneCodeError'=>['code'=>10000,'msg'=>'手机短信验证码错误!','error'=>'PhoneCodeError'],
    'PhoneUserError'=>['code'=>10000,'msg'=>'手机用户不存在!','error'=>'PhoneUserError'],

    //用户注册
    'SendUserRegisterCodeError'=>['code'=>10000,'msg'=>'发送注册验证码失败!','error'=>'SendUserRegisterCodeError'],

    //注册用户失败
    'AddUserError'=>['code'=>10000,'msg'=>'发送注册验证码失败!','error'=>'AddUserError'],
    'UserRegisterCodeTimeError'=>['code'=>10000,'msg'=>'用户注册验证码超时!','error'=>'UserRegisterCodeTimeError'],
    'UserRegisterCodeError'=>['code'=>10000,'msg'=>'用户注册验证码错误!','error'=>'UserRegisterCodeError'],

    //注册用户事件
    'AddUserInfoError'=>['code'=>10000,'msg'=>'添加用户详情错误!','error'=>'AddUserInfoError'],
    'AddUserAlbumError'=>['code'=>10000,'msg'=>'添加用户相册错误!','error'=>'AddUserAlbumError'],
    'AddUserAvatarError'=>['code'=>10000,'msg'=>'添加用户头像错误!','error'=>'AddUserAvatarError'],
    'AddUserRoleError'=>['code'=>10000,'msg'=>'添加用户角色错误!','error'=>'AddUserRoleError'],
    'FindUserAlbumError'=>['code'=>10000,'msg'=>'查找用户相册失败!','error'=>'FindUserAlbumError'],
    'SaveUserQrcodeError'=>['code'=>10000,'msg'=>'保存用户二维码失败!','error'=>'SaveUserQrcodeError'],
    'AddUserQrcodeError'=>['code'=>10000,'msg'=>'添加用户二维码失败!','error'=>'AddUserQrcodeError'],
    'SaveUserSourceError'=>['code'=>10000,'msg'=>'保存用户上级失败!','error'=>'SaveUserSourceError'],
    'AddUserSourceUnionError'=>['code'=>10000,'msg'=>'添加用户源推荐!','error'=>'AddUserSourceUnionError'],

    //微信登录注册
    'WechatOfficialAddUserInfoError'=>['code'=>10000,'msg'=>'添加用户详情错误!','error'=>'WechatOfficialAddUserInfoError'],
    'WechatOfficialAddUserAlbumError'=>['code'=>10000,'msg'=>'添加用户相册错误!','error'=>'WechatOfficialAddUserAlbumError'],
    'WechatOfficialAddUserRoleError'=>['code'=>10000,'msg'=>'添加用户角色错误!','error'=>'WechatOfficialAddUserRoleError'],
     'WechatOfficialFindUserAlbumError'=>['code'=>10000,'msg'=>'查找用户相册失败!','error'=>'WechatOfficialFindUserAlbumError'],
    'WechatOfficialAddUserAvatarPictureError'=>['code'=>10000,'msg'=>'添加用户头像图片错误!','error'=>'WechatOfficialAddUserAvatarPictureError'],
    'WechatOfficialAddUserAvatarError'=>['code'=>10000,'msg'=>'添加用户头像错误!','error'=>'WechatOfficialAddUserAvatarError'],
    //绑定用户openid
    'WehcatOfficialBindUserOpenidError'=>['code'=>10000,'msg'=>'绑定用户openid错误!','error'=>'WehcatOfficialBindUserOpenidError'],
    'WehcatOfficialBindUserOpenidDoubleUserError'=>['code'=>10000,'msg'=>'绑定用户openid用户重复错误!','error'=>'WehcatOfficialBindUserOpenidDoubleUserError'],

    'WechatOfficialFindUserError'=>['code'=>10000,'msg'=>'查找绑定用户失败!','error'=>'WechatOfficialFindUserError'],

    //一键登录
    'LoginUniVerifyError'=>['code'=>10000,'msg'=>'uni_app一键登录错误!','error'=>'LoginUniVerifyError'],
    'LoginUniVerifyNoSercretError'=>['code'=>10000,'msg'=>'uni_app一键登录缺失秘钥!','error'=>'LoginUniVerifyNoSercretError'],
    'LoginUniVerifyParamError'=>['code'=>10000,'msg'=>'uni_app一键登录参数缺失!','error'=>'LoginUniVerifyParamError'],
    'LoginUniVerifyNoCloudUrlError'=>['code'=>10000,'msg'=>'uni_app一键登录云函数缺失!','error'=>'LoginUniVerifyNoCloudUrlError'],
    'LoginUniVerifyDisabledUserError'=>['code'=>10000,'msg'=>'uni_app一键登录后手机用户被禁用!','error'=>'LoginUniVerifyDisabledUserError'],

    'AddUserByUniverifyError'=>['code'=>10000,'msg'=>'uni_app一键登录注册用户失败!','error'=>'AddUserByUniverifyError'],

    //用户id登录
    'LoginByUserIdError'=>['code'=>10000,'msg'=>'通过用户id登录失败!','error'=>'LoginByUserIdError'],

    //退出
    'LogoutError'=>['code'=>10000,'msg'=>'用户退出失败!','error'=>'LogoutError'],



];
