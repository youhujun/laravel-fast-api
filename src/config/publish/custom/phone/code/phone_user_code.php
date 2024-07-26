<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 17:20:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-16 10:22:51
 * @FilePath: \config\custom\phone\code\phone_user_code.php
 */

return [
    //实名认证
    'UserRealAuthApplyError'=>['code'=>10000,'msg'=>'用户申请实名认证失败','error'=>'UserRealAuthApplyError'],
    'UpdateUserRealAuthStatusError'=>['code'=>10000,'msg'=>'更新实名认证申请状态失败!','error'=>'UpdateUserRealAuthStatusError'],
    'UserHasRealAuthApplyError'=>['code'=>10000,'msg'=>'已经实名认证了!','error'=>'UserHasRealAuthApplyError'],
    'UserRealAuthApplyNoUserInfoError'=>['code'=>10000,'msg'=>'用户申请实名认证缺失用户信息','error'=>'UserRealAuthApplyNoUserInfoError'],
    'UserRealAuthApplySaveUserInfoError'=>['code'=>10000,'msg'=>'用户申请实名认证保存用户信息失败','error'=>'UserRealAuthApplySaveUserInfoError'],
    'UserRealAuthApplySaveUserIdCardError'=>['code'=>10000,'msg'=>'用户申请实名认证保存用户身份证信息失败','error'=>'UserRealAuthApplySaveUserIdCardError'],

    //清理缓存
    'ClearUserCacheError'=>['code'=>10000,'msg'=>'清理缓存失败!','error'=>'ClearUserCacheError'],

    'ClearUserCacheError'=>['code'=>10000,'msg'=>'清理缓存失败!','error'=>'ClearUserCacheError'],

];
