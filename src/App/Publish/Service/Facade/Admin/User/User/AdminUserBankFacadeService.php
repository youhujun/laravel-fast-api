<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-09 19:48:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 17:10:32
 * @FilePath: \app\Service\Facade\Admin\User\User\AdminUserBankFacadeService.php
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

use App\Service\Facade\Trait\QueryService;

//用户银行卡
use App\Models\User\UserBank;

use App\Http\Resources\User\UserBankCollection;

/**
 * @see \App\Facade\Admin\User\User\AdminUserBankFacade
 */
class AdminUserBankFacadeService
{
   public function test()
   {
       echo "AdminUserBankFacadeService test";
   }

   use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

   /**
     * 添加用户银行卡
     *
     * @param [type] $validated
     * @param [type] $administrator
     * @return void
     */
    public function addUserBank($validated,$administrator)
    {
         $result = code(config('admin_code.AddUserBankError'));

         $userBank = new UserBank;

         $userBank->created_time = time();
         $userBank->created_at = time();

         if($validated['is_default'] == 1)
         {
             $where = [];
             $where[] = ['user_id','=',$validated['user_id']];
             $where[] = ['is_default','=',1];

             $updateUserBank = UserBank::where($where)->get();

             if( $updateUserBank->count() > 0)
             {
                 $updateData = ['updated_time'=>time(),'updated_at'=>date('Y-m-d H:i:s',time()),'is_default'=>0];

                 $updateResult = UserBank::where($where)->update($updateData);
             }
         }

         $userBank->is_default = $validated['is_default'];

         $userBank->sort = $validated['sort'];
         $userBank->user_id = $validated['user_id'];
         $userBank->bank_id = $validated['bank_id'];
         $userBank->bank_number = $validated['bank_number'];
         $userBank->bank_account = $validated['bank_account'];
         $userBank->bank_address = isset($validated['bank_address'])?$validated['bank_address']:'';

        $userBank->bank_front_id = $validated['bank_front_id'];
        $userBank->bank_back_id = $validated['bank_back_id'];


         $userBankResult = $userBank->save();

        if(!$userBankResult )
        {
            throw new CommonException('AddUserBankError');
        }

        CommonEvent::dispatch($administrator,$validated,'AddUserBank')[0];

        $result =  code(['code'=> 0,'msg'=>'添加用户银行卡成功!']);

        return $result;

    }


    /**
     * 设置默认银行
     *
     * @param [type] $validated
     * @param [type] $administrator
     * @return void
     */
    public function setUserDefaultBank($validated,$administrator)
    {
        $result = code(config('admin_code.SetDefaultUserBankError'));

        $where = [];
        $where[] = ['user_id','=',$validated['user_id']];

        $where[] = ['is_default','=',1];

        $updateUserBank = UserBank::where($where)->get();

        if( $updateUserBank->count() > 0)
        {
            $updateData = ['updated_time'=>time(),'updated_at'=>date('Y-m-d H:i:s',time()),'is_default'=>0];

            $updateResult = UserBank::where($where)->update($updateData);

            if(!$updateResult)
            {
                throw new CommonException('SetDefaultUserBankOtherError');
            }
        }

        $where = [];

        $where[] = ['id','=',$validated['id']];

        $updateData = ['updated_time'=>time(),'updated_at'=>date('Y-m-d H:i:s',time()),'is_default'=>1];

        $updateResult = UserBank::where($where)->update($updateData);

        if(!$updateResult)
        {
            throw new CommonException('SetDefaultUserBankError');
        }

        CommonEvent::dispatch($administrator,$validated,'SetDefaultUserBank');

        $result =  code(['code'=> 0,'msg'=>'设置用户默认银行卡成功!']);

        return $result;

    }

     /**
     * 删除银行
     *
     * @param [type] $validated
     * @param [type] $administrator
     * @return void
     */
    public function deleteUserBank($validated,$administrator)
    {
        $result = code(config('admin_code.DeleteUserBankError'));

        $userBank = UserBank::find($validated['id']);

        $userBank->deleted_time = time();

        $userBank->deleted_at = time();

        $deleteResult = $userBank->save();

        if(!$deleteResult)
        {
            throw new CommonException('DeleteUserBankError');
        }

        CommonEvent::dispatch($administrator,$validated,'DeleteUserBank');

        $result = code(['code'=> 0,'msg'=>'删除用户银行卡成功!']);

        return $result;
    }


    /**
     *获取用户银行卡
     *
     * @return void
     */
    public function getUserBank($validated,$administrator)
    {
        $result = code(config('admin_code.GetUserBankError'));

        $this->withWhere = ['bank','bankFront','bankBack'];

        $this->where = [
            ['user_id','=',$validated['user_id']]
        ];

        $userBankCollection = UserBank::with($this->withWhere)->where($this->where)->get();

        if(\optional($userBankCollection))
        {
            $result = new UserBankCollection($userBankCollection,['code'=> 0,'msg'=>'获取用户银行卡成功!']);
        }

        return $result;
    }
}
