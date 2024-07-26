<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-09 19:49:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 19:37:25
 * @FilePath: \app\Service\Facade\Admin\User\User\AdminUserAccountFacadeService.php
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
use App\Events\Admin\User\User\SetUserAccountEvent;

use App\Service\Facade\Trait\QueryService;

use App\Models\User\User;
use App\Models\User\Log\UserBalanceLog;
use App\Models\User\Log\UserCoinLog;
use App\Models\User\Log\UserScoreLog;

use App\Http\Resources\User\UserAccountLogCollection;

/**
 * @see \App\Facade\Admin\User\User\AdminUserAccountFacade
 */
class AdminUserAccountFacadeService
{
   public function test()
   {
       echo "AdminUserAccountFacadeService test";
   }

   protected $model = [
       10 => UserBalanceLog::class,
       20 => UserCoinLog::class,
       30 => UserScoreLog::class,
   ];

   protected $field = [
       10 => 'balance',
       20 => 'coin',
       30 => 'score'
   ];

   use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

    /**
     * 后台修改用户账户余额
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
   public function setUserAccount($validated,$admin)
   {
        $result = code(\config('admin_code.SetUserAccountError'));

        $action_type = [10,20];

        if(!in_array($validated['action_type'],$action_type))
        {
             throw new CommonException('SetUserAccountActionTypeError');
        }

        $account_type = [10,20,30];

        if(!in_array($validated['account_type'],$account_type))
        {
            throw new CommonException('SetUserAccountTypeError');
        }

        $user = User::find($validated['user_id']);

        if(!$user)
        {
            throw new CommonException('ThisUserNotExistsError');
        }

        $account = [ 10 => $user->balance,20 => $user->coin, 30 => $user->score];

        $where = [];

        $where[] = ['id','=',$user->id];
        $where[] = ['revision', '=' ,$user->revision];

        $updateData = [
            'updated_at' => \showTime(time(),true),
            'updated_time' => time(),
            'revision' => $user->revision + 1
        ];

        //判断操作类型 10 充值 20扣除
        if($validated['action_type'] == 10)
        {
            $updateData[$this->field[$validated['account_type']]] = \bcadd($account[$validated['account_type']],$validated['amount'],2);
        }

        if ($validated['action_type'] == 20)
        {
            //相减的话需要比较一下大小 不能减出负数
            // 0== > 1 < -1
            $bccompResult = bccomp($validated['amount'],$account[$validated['account_type']]);

            if($bccompResult == 1)
            {
                throw new CommonException('SetUserAccountNotEnoughError');
            }

            $updateData[$this->field[$validated['account_type']]] = \bcsub($account[$validated['account_type']],$validated['amount'],2);
        }



        $accountResult = User::where($where)->update($updateData);

        if(!$accountResult)
        {
            DB::rollBack();

            throw new CommonException('SetUserAccountError');
        }

        SetUserAccountEvent::dispatch($admin,$validated);

        CommonEvent::dispatch($admin,$validated,'SetUserAccount',1);

        DB::commit();

        $result = code(['code'=>0,'msg'=>'设置用户账户成功!']);

        return $result;
   }

   /**
    * 获取用户账户日志
    *
    * @param  [type] $validated
    * @param  [type] $admin
    */
   public function getUserAccountLog($validated,$admin)
   {
       $result = code(config('admin_code.GetUserAccountLogError'));

       $this->setQueryOptions($validated);

       $where = [];

       if($validated['user_id'])
       {
             $where[] = ['user_id','=',$validated['user_id']];
       }

       if(isset($validated['action_type']) && $validated['action_type'])
       {
            $where[] = ['type','=',$validated['action_type']];
       }

       $query = $this->model[$validated['account_type']]::where($where);

        if(isset($validated['timeRange']) && \count($validated['timeRange']) > 0)
        {
            if(isset($validated['timeRange'][0]) && !empty($validated['timeRange'][0]))
            {
                $this->whereBetween[] = [\strtotime($validated['timeRange'][0])];
            }

            if(isset($validated['timeRange'][1]) && !empty($validated['timeRange'][1]))
            {
                $this->whereBetween[] = [\strtotime($validated['timeRange'][1])];
            }

            if(isset($this->whereBetween) && count($this->whereBetween) > 0)
            {
                $query->whereBetween('created_time',$this->whereBetween);
            }

        }

        if(isset($validated['sortType']))
        {
            $sortType = $validated['sortType'];

            $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }

        $accountLogList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        //p($accountLogList);die;

        if(\optional($accountLogList))
        {
            $result = new UserAccountLogCollection($accountLogList,['code'=> 0,'msg'=>'获取用户账户成功!'],null);
        }

        return  $result;
   }
}
