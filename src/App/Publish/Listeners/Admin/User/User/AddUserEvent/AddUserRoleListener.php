<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 03:06:30
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 20:23:54
 * @FilePath: \app\Listeners\Admin\User\User\AddUserEvent\AddUserRoleListener.php
 */

namespace App\Listeners\Admin\User\User\AddUserEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\Union\UserRoleUnion;

/**
 * @see \App\Events\Admin\User\User\AddUserEvent
 */
class AddUserRoleListener
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

        //如果没有普通会员要添加上普通会员
        $data = [];
        $date = date('Y-m-d H:i:s',time());
        $time = time();
        $user_id = $user->id;

        $data[] = ['created_at' =>$date,'created_time'=>$time,'user_id'=>$user->id,'role_id'=>4];

        $userRoleUnionResult = UserRoleUnion::insert($data);

        if(!$userRoleUnionResult)
        {
            throw new CommonException('AddUserRoleError');
        }
    }
}
