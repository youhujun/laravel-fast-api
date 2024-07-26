<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-19 22:02:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 07:58:28
 * @FilePath: \app\Service\Facade\Admin\User\User\AdminUserRealAuthFacadeService.php
 */

namespace App\Service\Facade\Admin\User\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;
use App\Events\Admin\User\User\CheckUserRealAuthEvent;
use App\Events\Admin\User\User\SetUserIdCardEvent;

use App\Service\Facade\Trait\QueryService;

use App\Models\User\User;
use App\Models\User\UserApplyRealAuth;
use App\Models\User\UserInfo;
use App\Models\User\UserIdCard;

use App\Http\Resources\User\UserApplyRealAuthCollection;
use App\Http\Resources\User\UserResource;

/**
 * @see \App\Facade\Admin\User\User\AdminUserRealAuthFacade
 */
class AdminUserRealAuthFacadeService
{
   public function test()
   {
       echo "AdminUserRealAuthFacadeService test";
   }

   use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

   /**
    * 获取用户实名认证申请
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function getUserRealAuthApply($validated,$admin)
   {
       $result = code(config('admin_code.GetUserRealAuthApplyError'));

       $this->setQueryOptions($validated);

       $where = [];

       $where[] = ['user_id','=',$validated['user_id']];

       $query = UserApplyRealAuth::where($where);

        if(isset($validated['sortType']))
        {
            $sortType = $validated['sortType'];

            $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }

        $userApplyRealAuthList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(\optional($userApplyRealAuthList))
        {
            $result = new UserApplyRealAuthCollection($userApplyRealAuthList,['code'=> 0,'msg'=>'获取用户实名认证申请成功!'],null);
        }

        return  $result;

   }

   /**
     * 实名认证技师
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function realAuthUser($validated,$admin)
    {
        $result = code(config('admin_code.RealAuthUserError'));

        $user = User::find($validated['user_id']);

        if(!$user)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $revision = $user->revision;

        $updateData = ['updated_time'=>time(),'updated_at'=>\date('Y-m-d H:i:s',time()),'revision'=>$revision + 1];

        //默认审核不通过
        $updateData['real_auth_status'] = 30;

        if($validated['is_real_auth'])
        {
            //审核通过
            $updateData['real_auth_status'] = 40;
        }

        $userResult = User::where('id',$validated['user_id'])->where('revision',$revision)->update($updateData);

        if(!$userResult)
        {
            throw new CommonException('RealAuthUserError');
        }

        CheckUserRealAuthEvent::dispatch($admin,$validated);

        CommonEvent::dispatch($admin,$validated,'RealAuthUser');

        $result = code(['code'=> 0,'msg'=>'审核实名认证用户成功!']);

        return $result;
    }

      /**
    * 修改用户身份证号
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
    public function updateUserIdNumber($validated,$admin)
    {
         $result = code(config('admin_code.UpdateUserIdNumberError'));

         $user = UserInfo::find($validated['user_id']);

         $where = [];
         $updateData = [];

         $revision = $user->revision;

         $where[] = ['id','=',$user->id];
         $where[] = ['revision','=',$revision];

         $updateData = [
             'revision'=>$revision + 1,
             'id_number'=>$validated['id_number'],
             'updated_at'=>date('Y-m-d H:i:s',time()),
             'updated_time'=>time(),
         ];

         $updateIdNumberResult = UserInfo::where($where)->update($updateData);

         if(!$updateIdNumberResult)
         {
            throw new CommonException('UpdateUserIdNumberError');
         }

         CommonEvent::dispatch($admin,$validated,'UpdateUserIdNumber');

         $result = code(['code'=> 0,'msg'=>'修改用户身份证号成功!']);

         return $result;
    }

    /**
     *获取用户身份证
     *
     * @return void
     */
    public function getUserIdCard($validated,$admin)
    {
        $result = code(config('admin_code.getUserIdCardError'));

        $this->withWhere = ['userInfo','idCard','idCard.cardFront','idCard.cardBack'];

        if(!isset($validated['user_id']))
        {
            throw new CommonException('RequestNoParamError');
        }

        $user = User::with($this->withWhere)->find($validated['user_id']);

        //p($user);die;

        if(!$user)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        //p($user);die;

        $data = [];
        $data['data'] = new UserResource($user);

        $result = code(['code'=> 0,'msg'=>'获取用户身份证成功!'],$data);

        return $result;
    }

     /**
    * 设置用户身份证照片
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
    public function setUserIdCard($validated,$admin)
    {
         $result = code(config('admin_code.SetUserIdCardError'));

         $userIdCard = new UserIdCard;

         $userIdCard->created_time = time();
         $userIdCard->created_at = time();

         $userIdCard->sort = $validated['sort'];
         $userIdCard->user_id = $validated['user_id'];

         if(($validated['id_card_front_id']))
         {
            $userIdCard->id_card_front_id = $validated['id_card_front_id'];
         }

         if(($validated['id_card_back_id']))
         {
            $userIdCard->id_card_back_id = $validated['id_card_back_id'];
         }

        $userIdCardResult = $userIdCard->save();

        if(!$userIdCardResult)
        {
            throw new CommonException('SetUserIdCardError');
        }

        SetUserIdCardEvent::dispatch($admin,$validated);

        CommonEvent::dispatch($admin,$validated,'SetUserIdCard');

        $result =  code(['code'=> 0,'msg'=>'设置用户身份证成功!']);

        return $result;

    }
}
