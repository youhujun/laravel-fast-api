<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 10:36:36
 * @FilePath: \routes\api\admin\user.php
 */

/**模板路由 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


$namespace = 'App\\Http\\Controllers\\Admin\\User';

/**
 * 后端模版
 */
 Route::prefix(config('custom.version'))->namespace($namespace)->middleware('admin.login')->group(function()
{
    Route::prefix('admin')->group(function()
    {

            Route::namespace('Admin')->group(function()
            {
                /**
                 * 管理员管理
                 * @see \App\Http\Controllers\Admin\User\Admin\AdministratorController
                 */
                 Route::controller(AdministratorController::class)->group(function()
                {
                     //获取所有管理员用户信息
                    Route::get('getDefaultAdmin','getDefaultAdmin');
                    //查找管理员信息
                    Route::post('findAdmin','findAdmin');

                    //获取管理员
                    Route::post('getAdmin','getAdmin');
                    //添加管理员
                    Route::post('addAdmin','addAdmin');
                    //更新管理员
                    Route::post('updateAdmin','updateAdmin');
                    //删除管理员
                    Route::post('deleteAdmin','deleteAdmin');
                    //批量删除管理员
                    Route::post('multipleDeleteAdmin','multipleDeleteAdmin');
                    //禁用管理员
                    Route::post('disableAdmin','disableAdmin');
                    //批量禁用管理员
                    Route::post('multipleDisableAdmin','multipleDisableAdmin');

                });
            });

            Route::namespace('User')->group(function()
            {
                /**
                 * 用户管理
                 * @see \App\Http\Controllers\Admin\User\User\UserController
                 */
                Route::controller(UserController::class)->group(function()
                {
                    //获取用户
                    Route::post('getUser','getUser');
                    //添加用户 注册用户
                    Route::post('addUser','addUser');
                    //删除用户
                    Route::post('deleteUser','deleteUser');
                    //批量删除用户
                    Route::post('multipleDeleteUser','multipleDeleteUser');
                    //禁用用户
                    Route::post('disableUser','disableUser');
                    //批量禁用用户
                    Route::post('multipleDisableUser','multipleDisableUser');

                });

                /**
                * 用户选项
                * bind
                * @see \App\Http\Controllers\Admin\User\User\UserItemController
                    */
                Route::controller(UserItemController::class)->group(function()
                {
                    //获取选项用户
                    Route::get('getDefaultUser','getDefaultUser');
                    //查找用户
                    Route::post('findUser','findUser');
                });

                /**
                 *  @see \App\Http\Controllers\Admin\User\User\UserRealAuthController
                 */
                Route::controller(UserRealAuthController::class)->group(function()
                {
                    //获取用户实名认证申请
                    Route::post('getUserRealAuthApply','getUserRealAuthApply');

                    // 审核实名认证用户
                    Route::post('realAuthUser','realAuthUser');

                    //用户身份证
                    //设置 用户身份证
                    Route::post('setUserIdCard','setUserIdCard');
                    //获取用户身份证
                    Route::post('getUserIdCard','getUserIdCard');
                    //修改用户身份证号
                    Route::post('updateUserIdNumber','updateUserIdNumber');
                });

                /**
                * 用户详情
                * bind
                * @see \App\Http\Controllers\Admin\User\User\UserDetailsController
                */
                Route::controller(UserDetailsController::class)->group(function()
                {
                    //用户修改
                    //修改用户手机号
                    Route::post('updateUserPhone','updateUserPhone');
                    //修改用户真是姓名
                    Route::post('updateUserRealName','updateUserRealName');
                    //修改用户昵称
                    Route::post('updateUserNickName','updateUserNickName');
                    //修改用户性别
                    Route::post('updateUserSex','updateUserSex');
                    //更改用户级别
                    Route::post('changeUserLevel','changeUserLevel');

                    //修改用户生日
                    Route::post('updateUserBirthdayTime','updateUserBirthdayTime');
                    //重置用户密码
                    Route::post('resetUserPassword','resetUserPassword');

                    //获取用户二维码
                    Route::post('getUserQrcode','getUserQrcode');

                });

                /**
                * 用户地址
                * bind
                * @see \App\Http\Controllers\Admin\User\User\UserAddressController
                    */
                Route::controller(UserAddressController::class)->group(function()
                {
                    //用户地址
                    //获取用户地址
                    Route::get('getUserAddress','getUserAddress');
                    //添加用户地址
                    Route::post('addUserAddress','addUserAddress');
                    //删除用户地址
                    Route::get('deleteUserAddress','deleteUserAddress');
                    //设为默认地址
                    Route::get('setDefaultUserAddress','setDefaultUserAddress');
                });

                /**
                * 用户银行卡
                * bind
                * @see \App\Http\Controllers\Admin\User\user\UserBankController
                    */
                Route::controller(UserBankController::class)->group(function()
                {
                        //用户银行卡
                    //添加银行卡
                    Route::post('addUserBank','addUserBank');
                    //设置默认银行卡
                    Route::post('setUserDefaultBank','setUserDefaultBank');
                    //删除银行卡
                    Route::post('deleteUserBank','deleteUserBank');
                    //获取用户银行卡
                    Route::post('getUserBank','getUserBank');
                });

                /**
                * 用户团队
                * bind
                * @see  \App\Http\Controllers\Admin\User\User\UserTeamController
                    */
                Route::controller(UserTeamController::class)->group(function()
                {
                    //获取用户的上级用户(推荐用户)
                    Route::post('getUserSource','getUserSource');
                    //获取用户下级团队
                    Route::post('getUserLowerTeam','getUserLowerTeam');
                });


                /**
                 * @see \App\Http\Controllers\Admin\User\User\UserAccountController
                 */
                Route::controller(UserAccountController::class)->group(function()
                {
                    //设置用户账户
                    Route::post('setUserAccount','setUserAccount');
                    //获取用户账户日志
                    Route::post('getUserAccountLog','getUserAccountLog');
                });

            });


   });
});


Route::fallback(function ()
{
    $data = ['code'=>500,'msg'=>'路由错误'];

    return $data;
});


