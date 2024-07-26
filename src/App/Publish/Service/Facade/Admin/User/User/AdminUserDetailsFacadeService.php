<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-09 19:48:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-27 01:53:11
 * @FilePath: \app\Service\Facade\Admin\User\User\AdminUserDetailsFacadeService.php
 */

namespace App\Service\Facade\Admin\User\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Plunar\Plunar;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Service\Facade\Trait\QueryService;

//模型
//用户
use App\Models\User\User;
//用户地址
use App\Models\User\UserAddress;
//用户详情
use App\Models\User\UserInfo;
//用户银行卡
use App\Models\User\UserBank;

use App\Models\User\UserIdCard;
//用户申请实名认证表
use App\Models\User\UserApplyRealAuth;
//用户父关联表
use App\Models\User\Union\UserSourceUnion;
//用户二维码表
use App\Models\User\UserQrcode;

//响应资源
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\System\Picture\AlbumPictureResource;

/**
 * @see \App\Facade\Admin\User\User\AdminUserDetailsFacade
 */
class AdminUserDetailsFacadeService
{
   public function test()
   {
       echo "AdminUserDetailsFacadeService test";
   }

   use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];


   /**
    * 修改用户手机号
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function updateUserPhone($validated,$admin)
   {
        $result = code(config('admin_code.UpdateUserPhoneError'));

        $user = User::find($validated['user_id']);

        $where = [];
        $updateData = [];

        $revision = $user->revision;

        $where[] = ['id','=',$user->id];
        $where[] = ['revision','=',$revision];

        $updateData = [
            'revision'=>$revision + 1,
            'phone'=>$validated['phone'],
            'updated_at'=>date('Y-m-d H:i:s',time()),
            'updated_time'=>time(),
        ];

        $updatePhoneResult = User::where($where)->update($updateData);

        if(!$updatePhoneResult)
        {
            throw new CommonException('UpdateUserPhoneError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdateUserPhone');

        $result = code(['code' => 0,'msg' => '更新用户手机号成功']);

        return $result;
   }



   /**
    * 修改用户真实姓名
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function updateUserRealName($validated,$admin)
   {
        $result = code(config('admin_code.UpdateUserRealNameError'));

        $userInfo = UserInfo::where('user_id',$validated['user_id'])->first();

        $where = [];
        $updateData = [];

        $revision = $userInfo->revision;

        $where[] = ['id','=',$userInfo->id];
        $where[] = ['revision','=',$revision];

        $updateData = [
            'revision'=>$revision + 1,
            'real_name'=>$validated['real_name'],
            'updated_at'=>date('Y-m-d H:i:s',time()),
            'updated_time'=>time(),
        ];

        $updateRealNameResult = UserInfo::where($where)->update($updateData);

        if(!$updateRealNameResult)
        {
            throw new CommonException('UpdateUserRealNameError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdateUserRealName');

        $result = code(['code' => 0,'msg' => '更新用户姓名成功']);

        return $result;
   }


   /**
    * 修改用户昵称
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
    public function updateUserNickName($validated,$admin)
    {
         $result = code(config('admin_code.UpdateUserNickNameError'));

         $userInfo = UserInfo::find($validated['user_id']);
         $where = [];
         $updateData = [];

         $revision = $userInfo->revision;

         $where[] = ['id','=',$userInfo->id];
         $where[] = ['revision','=',$revision];

         $updateData = [
             'revision'=>$revision + 1,
             'nick_name'=>$validated['nick_name'],
             'updated_at'=>date('Y-m-d H:i:s',time()),
             'updated_time'=>time(),
         ];

         $updateNickNameResult = UserInfo::where($where)->update($updateData);

         if(!$updateNickNameResult)
         {
             throw new CommonException('UpdateUserNickNameError');
         }

         CommonEvent::dispatch($admin,$validated,'UpdateUserNickName');

         $result = code(['code' => 0,'msg' => '更新用户昵称成功']);

         return $result;
    }




   /**
    * 修改用户性别
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
    public function updateUserSex($validated,$admin)
    {
         $result = code(config('admin_code.UpdateUserSexError'));

         $userInfo = UserInfo::find($validated['user_id']);

         $where = [];
         $updateData = [];

         $revision = $userInfo->revision;

         $where[] = ['id','=',$userInfo->id];
         $where[] = ['revision','=',$revision];

         $updateData = [
             'revision'=>$revision + 1,
             'sex'=>$validated['sex'],
             'updated_at'=>date('Y-m-d H:i:s',time()),
             'updated_time'=>time(),
         ];

         $updateSexResult = UserInfo::where($where)->update($updateData);

         if(!$updateSexResult)
         {
            throw new CommonException('UpdateUserSexError');
         }

         CommonEvent::dispatch($admin,$validated,'UpdateUserSex');

         $result = code(['code' => 0,'msg' => '更新用户性别成功']);

         return $result;
    }

     /**
     * 更改用户级别
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function changeUserLevel($validated,$admin)
    {
        $result = code(config('admin_code.ChangeUserLevelError'));

        $user = User::find($validated['id']);

        $revision = $user->revision;

        $updateData = ['level_id'=>$validated['level_id'],'updated_time'=>time(),'updated_at'=>\date('Y-m-d H:i:s',time()),'revision'=>$revision + 1];

        $userResult = User::where('id',$validated['id'])->where('revision',$revision)->update($updateData);

        if(!$userResult)
        {
            throw new CommonException('ChangeUserLevelError');
        }

        CommonEvent::dispatch($admin,$validated,'ChangeUserLevel');

        $result = code(['code' => 0,'msg' => '更新用户级别成功']);

        return $result;
    }

    /**
    * 修改用户性别
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
    public function updateUserBirthdayTime($validated,$admin)
    {
         $result = code(config('admin_code.UpdateUserBirthdayTimeError'));

         $userInfo = UserInfo::find($validated['user_id']);

         $where = [];
         $updateData = [];

         $revision = $userInfo->revision;

         $where[] = ['id','=',$userInfo->id];
         $where[] = ['revision','=',$revision];

         if(isset($validated['solar_birthday_time']))
        {
            $lunar_array = Plunar::solarToLunar($validated['solar_birthday_time']);
            $year = data_get($lunar_array,'6.0');
            $month = Str::length(data_get($lunar_array,'6.1')) == 1? '0'.data_get($lunar_array,'6.1'):data_get($lunar_array,'6.1');
            $day = data_get($lunar_array,'6.2');
            $lunar = $year.'-'.$month.'-'.$day;
        }

         $updateData = [
             'revision'=>$revision + 1,
             'solar_birthday_at'=>$validated['solar_birthday_time'],
             'solar_birthday_time'=>$validated['solar_birthday_time']?\strtotime($validated['solar_birthday_time']):0,
             'chinese_birthday_at'=>$lunar,
             'chinese_birthday_time'=> \strtotime($lunar),
             'updated_at'=>date('Y-m-d H:i:s',time()),
             'updated_time'=>time(),
         ];

         $updateSexResult = UserInfo::where($where)->update($updateData);

         if(!$updateSexResult)
         {
             throw new CommonException('UpdateUserBirthdayTimeError');
         }

         CommonEvent::dispatch($admin,$validated,'UpdateUserBirthdayTime');

         $result = code(['code' => 0,'msg' => '更新用户出生日期成功']);

         return $result;
    }

    /**
    * 重置用户密码
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
    public function resetUserPassword($validated,$admin)
    {
        $result = code(config('admin_code.ResetUserPasswordError'));

        $user = User::find($validated['user_id']);

        if(!$user)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];
        $updateData = [];

        $revision = $user->revision;

        $where[] = ['id','=',$user->id];
        $where[] = ['revision','=',$revision];

        $updateData = [
            'revision' => $revision + 1,
            'password' => Hash::make($validated['password']),
            'updated_at' => \showTime(time(),true),
            'updated_time' => time(),
        ];

        $updateResult = User::where($where)->update($updateData);

        if(!$updateResult)
        {
        throw new CommonException('ResetUserPasswordError');
        }

        CommonEvent::dispatch($admin,$validated,'ResetUserPassword');

        $result = code(['code' => 0,'msg' => '重置用户密码成功']);

        return $result;
    }


    /**
     * 获取用户二维码
     */
    public function getUserQrcode($validated,$admin)
    {
        $result = code(config('admin_code.GetUserQrcodeError'));

        $where = [];
        $where[] = ['user_id','=',$validated['user_id']];
        $where[] = ['is_default','=',1];

        $userQrcode = UserQrcode::with(['albumPicture'])->where($where)->first();

        $data = [];

        if($userQrcode)
        {
            $userOrcodeArrayObject = $userQrcode->getRelations('ablbumPicture');

            $userQrcodePictureObject = $userOrcodeArrayObject['albumPicture'];

            $data['data'] = new AlbumPictureResource($userQrcodePictureObject);
        }

        $result = code(['code'=> 0 ,'msg'=>'获取用户二维码成功'],$data);

        return $result;
    }
}
