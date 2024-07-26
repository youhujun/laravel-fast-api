<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-26 07:37:56
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 07:44:14
 * @FilePath: \app\Listeners\Admin\User\User\CheckUserRealAuthEvent\UpdateUserRealAuthApplyListener.php
 */

namespace App\Listeners\Admin\User\User\CheckUserRealAuthEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\UserApplyRealAuth;

/**
 * @see \App\Events\Admin\User\User\CheckUserRealAuthEvent
 */
class UpdateUserRealAuthApplyListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $admin = $event->admin;
        $validated = $event->validated;

        $userApplayRealAuth = UserApplyRealAuth::find($validated['id']);

        if(optional($userApplayRealAuth))
        {
            if($userApplayRealAuth->status !== 10)
            {
                throw new CommonException('RealAuthApplyHasError');
            }

            $userApplayRealAuthRevision = $userApplayRealAuth->revision;

            if($validated['is_real_auth'])
            {
                $userApplayRealAuthUpdateData = ['status'=> 20,'updated_time'=>time(),'updated_at'=>\date('Y-m-d H:i:s',time()),'revision'=>$userApplayRealAuthRevision + 1];
            }
            else
            {
                 $userApplayRealAuthUpdateData = ['status'=> 30,'updated_time'=>time(),'updated_at'=>\date('Y-m-d H:i:s',time()),'revision'=>$userApplayRealAuthRevision + 1,'refuse_info'=>$validated['refuse_info']];
            }

            $where[] = ['revision','=',$userApplayRealAuthRevision];
            $where[] = ['id','=',$validated['id']];

            $userApplayRealAuthResult = UserApplyRealAuth::where($where)->update($userApplayRealAuthUpdateData);

            if(!$userApplayRealAuthResult)
            {
                throw new CommonException('RealAuthApplyError');
            }
        }
    }
}
