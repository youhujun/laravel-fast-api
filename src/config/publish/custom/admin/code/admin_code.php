<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-21 21:30:22
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 11:28:17
 * @FilePath: \config\custom\admin\code\admin_code.php
 */

//后台错误码
$systemCodeArray = [

    //发送异常邮件通知定义
    'EmailArray' =>[
        //'serverError',
    ],

    'AddMessageError'=>[ 'code'=>10000, 'msg'=>'添加消息错误!','error'=>'AddMessageError' ],
    //服务器异常错误  这种情况下是调用公共异常没有传入错误码
    'ServerError'=>[ 'code'=>50000, 'msg'=>'服务器异常错误!','error'=>'ServerError' ],
    'CodeError'=>[ 'code'=>51010, 'msg'=>'错误码不存!','error'=>'CodeError' ],

    /************************平台系统--platform********************* */

    //未传递请求参数
    'RequestNoParamError'=>['code'=>90000, 'msg'=>'未传递请求参数','error'=>'RequestNoParamError'],
    //中间件验证失败
    'AdminTokenError'=>[ 'code'=>90010, 'msg'=>'无效的token,请重新登录','error'=>'AdminTokenError' ],
    //权限失败
    'AdminAuthError'=>[ 'code'=>90020, 'msg'=>'您不具有操作权限!','error'=>'AdminAuthError'],

    'ParamsIsNullError'=>[ 'code'=>10000, 'msg'=>'请求参数为空!','error'=>'ParamsIsNullError'],

    //用户修改删除数据时候,先查询不存在
    'ThisDataNotExistsError' => ['code' =>10000,'msg'=>'该数据不存在!','error'=>'ThisDataNotExistsError'],

    //有子级数据
    'ThisDataHasChildrenError' => ['code' =>10000,'msg'=>'该数据有子级存在!','error'=>'ThisDataHasChildrenError'],

    'SmsCodeSaveError'=>[ 'code'=>10000, 'msg'=>'短信验证码存储失败!','error'=>'SmsCodeSaveError'],

    //事件类型
    'EventTypeError'=>[ 'code'=>10000, 'msg'=>'获管事件类型失败','error'=>'EventTypeError' ],

    //配合登录
    'AdminUserRoleError' =>[ 'code'=>10000, 'msg'=>'后台用户角色不正确' ],
    'UserNotAdminRoleError' =>[ 'code'=>10000, 'msg'=>'用户不是管理员角色' ],
    'CheckAdminUserRoleError' =>[ 'code'=>10000, 'msg'=>'检测后台用户角色不正确' ],
    'UserHasNotAdminRoleError' =>[ 'code'=>10000, 'msg'=>'用户不具有管理员身份' ],
    'UserHasNotAdminIdError' =>[ 'code'=>10000, 'msg'=>'用户不具有管理员资格' ],

];

//开发者
$developCodeArray = [
    'AddDeveloperError' => [ 'code'=>10000, 'msg'=>'添加开发者失败','error'=>'AddDeveloperError' ],
    'AddDeveloperEventError' => [ 'code'=>10000, 'msg'=>'添加开发者事件失败','error'=>'AddDeveloperEventError' ],

    'AddDeveloperAlbumError' => [ 'code'=>10000, 'msg'=>'添加开发者相册失败','error'=>'AddDeveloperAlbumError' ],
    'AddDeveloperInfoError' => [ 'code'=>10000, 'msg'=>'添加开发者信息失败','error'=>'AddDeveloperInfoError' ],
    'AddDeveloperAvatarError' => [ 'code'=>10000, 'msg'=>'添加开发者头像失败','error'=>'AddDeveloperAvatarError' ],
    'AddDeveloperAdminError' => [ 'code'=>10000, 'msg'=>'添加开发者管理员失败','error'=>'AddDeveloperAdminError' ],
    'AddDeveloperRoleError' => [ 'code'=>10000, 'msg'=>'添加开发者角色失败','error'=>'AddDeveloperRoleError' ],
    'AddDeveloperAddressError' => [ 'code'=>10000, 'msg'=>'添加开发者地址失败','error'=>'AddDeveloperAddressError' ],
    'AddDeveloperQrcodeError' => [ 'code'=>10000, 'msg'=>'添加开发者二维码失败','error'=>'AddDeveloperQrcodeError' ],

];

$errorCodeArray = array_merge(
    $systemCodeArray,
    $developCodeArray
);

 return $errorCodeArray;
