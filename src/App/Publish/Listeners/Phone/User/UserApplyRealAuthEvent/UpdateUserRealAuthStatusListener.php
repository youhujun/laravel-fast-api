<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-16 10:16:18
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-16 10:35:30
 * @FilePath: \app\Listeners\Phone\User\UserApplyRealAuthEvent\UpdateUserRealAuthStatusListener.php
 */

namespace App\Listeners\Phone\User\UserApplyRealAuthEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;

use App\Exceptions\Phone\CommonException;
use App\Facade\Common\Common;
use App\Models\User\User;

class UpdateUserRealAuthStatusListener
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
        $user = $event->user;
        $validated = $event->validated;

        $isTransation = $event->isTransation;

        //将用户认证状态 改为认证中
        $user->real_auth_status = 20;

        $user->updated_at = time();

        $user->updated_time = time();

        $userResult = $user->save();

        if(!$userResult)
        {
            if(!$isTransation)
            {
                DB::rollBack();
            }

            throw new CommonException('UpdateUserRealAuthStatusError');
        }



    }
}
