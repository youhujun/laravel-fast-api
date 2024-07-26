<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 18:17:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 20:04:28
 * @FilePath: \app\Service\Facade\Admin\Log\AdminUserLogFacadeService.php
 */

namespace App\Service\Facade\Admin\Log;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Service\Facade\Trait\QueryService;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\User\Log\UserEventLog;
use App\Models\User\Log\UserLoginLog;

use App\Http\Resources\User\Log\UserLoginLogCollection;
use App\Http\Resources\User\Log\UserEventLogCollection;

/**
 * @see \App\Facade\Admin\Log\AdminUserLogFacade
 */
class AdminUserLogFacadeService
{
   public function test()
   {
       echo "AdminUserLogFacadeService test";
   }

    use QueryService;

    public static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

    /**
     *
     *获取登录日志
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function getUserLoginLog($validated,$admin)
    {
        $result = code(config('admin_code.GetUserLoginLogError'));

        $this->setQueryOptions($validated);

        //先处理关联
        $this->withWhere = ['user.userInfo'];

        $query = UserLoginLog::with($this->withWhere);
        //处理查询条件
        if(isset($validated['user_id']) && !empty($validated['user_id']))
        {
            $this->where[] = ['user_id','=',$validated['user_id']];

            $query->where($this->where);
        }

        if(isset($validated['status']) && !empty($validated['status']))
        {
              $this->where[] = ['status','=',$validated['status']];

              $query->where($this->where);
        }

        if(isset($validated['timeRange']) && \count($validated['timeRange']))
        {
             $this->whereBetween[] = strtotime($validated['timeRange'][0]);
             $this->whereBetween[] = strtotime($validated['timeRange'][1]);

             $query->whereBetween('created_time' ,$this->whereBetween);
        }

        if(isset($validated['sortType']))
        {
             $sortType = $validated['sortType'];

             $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }

        $loginLog = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(!optional($loginLog))
        {
           throw new CommonException('GetUserLoginLogError');
        }

        $result = new UserLoginLogCollection($loginLog,['code'=>0,'msg'=>'获取用户登录日志成功!']);

        return $result;

    }

    /**
     * 删除日志
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function deleteUserLoginLog($validated,$admin)
    {
        $result = code(config('admin_code.DeleteUserLoginLogError'));

        $deleteReuslt = UserLoginLog::find($validated['id'])->delete();

        if(! $deleteReuslt)
        {
            throw new CommonException('DeleteUserLoginLogError');
        }

        CommonEvent::dispatch($admin,$validated,'DeleteUserLoginLog');

        $result = code(['code'=>0,'msg'=>'删除用户登录日志成功!']);

        return $result;
    }

    /**
     * 多选删除
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function multipleDeleteUserLoginLog($validated,$user)
    {
        $result = code(config('admin_code.MultipleDeleteUserLoginLogError'));

        if(isset($validated['selectId']) && count($validated['selectId']))
        {
            $deleteResult = UserLoginLog::whereIn('id',$validated['selectId'])->delete();

            if(!$deleteResult)
            {
                throw new CommonException('MultipleDeleteUserLoginLogError');
            }

            CommonEvent::dispatch($user,$validated,'MultipleDeleteUserLoginLog');

            $result = code(['code'=>0,'msg'=>'批量删除用户登录日志成功!']);
        }

        return $result;
    }

    /**
     * 获取事件日志
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function getUserEventLog($validated,$user)
    {
        $result = code(config('admin_code.GetEventLogError'));

        $this->setQueryOptions($validated);

        //先处理关联
        $this->withWhere = ['user.userInfo'];

        $query = UserEventLog::with($this->withWhere);
        //处理查询条件
        if(isset($validated['user_id']) && empty(!$validated['user_id']))
        {
            $this->where[] = ['user_id','=',$validated['user_id']];

            $query->where($this->where);
        }

        if(isset($validated['eventType']) && !empty($validated['eventType']))
        {
              $this->where[] = ['event_type','=',$validated['eventType']];
        }

        if(isset($validated['timeRange']) && \count($validated['timeRange']))
        {
             $this->whereBetween[] = strtotime($validated['timeRange'][0]);
             $this->whereBetween[] = strtotime($validated['timeRange'][1]);

             $query->whereBetween('created_time' ,$this->whereBetween);
        }

        if(isset($validated['sortType']))
        {
             $sortType = $validated['sortType'];

             $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }

        $eventLog = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(!optional($eventLog))
        {
           throw new CommonException('GetEventLogError');
        }

         $result = new UserEventLogCollection($eventLog,['code'=>0,'msg'=>'获取用户事件日志成功!']);

        return $result;

    }

    /**
     * 删除事件日志
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function deleteUserEventLog($validated,$user)
    {
        $result = code(config('admin_code.DeleteEventLogError'));

        if(isset($validated['id']))
        {
            $deleteReuslt = UserEventLog::find($validated['id'])->delete();

            if(! $deleteReuslt)
            {
                throw new CommonException('DeleteEventLogError');
            }

           $result = code(['code'=>0,'msg'=>'删除用户事件日志成功!']);
        }

        return $result;
    }

    /**
     * 多选删除
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function multipleDeleteUserEventLog($validated,$user)
    {
        $result = code(config('admin_code.MultipleDeleteEventLogError'));

        if(isset($validated['selectId']) && count($validated['selectId']))
        {
            $deleteResult = UserEventLog::whereIn('id',$validated['selectId'])->delete();

            if(!$deleteResult)
            {
                throw new CommonException('MultipleDeleteEventLogError');
            }

            $result = code(['code'=>0,'msg'=>'批量删除用户事件日志成功!']);
        }

        return $result;
    }
}
