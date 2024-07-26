<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 08:12:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 22:29:34
 * @FilePath: \app\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserRoleListener.php
 */

namespace App\Listeners\Admin\Develop\AddDeveloperEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\Admin\CommonException;

use App\Models\User\Union\UserRoleUnion;

/**
 * @see \App\Events\Admin\Develop\AddDeveloperEvent
 */
class AddDeveloperUserRoleListener
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
        $admin = $event->admin;
        $validated = $event->validated;

        $data = [];
        $date = date('Y-m-d H:i:s',time());
        $time = time();
        $user_id = $user->id;

        //默认给开发者基础角色的所有身份
        $data[] = ['created_at' =>$date,'created_time'=>$time,'user_id'=>$user->id,'role_id'=>1];
        $data[] = ['created_at' =>$date,'created_time'=>$time,'user_id'=>$user->id,'role_id'=>2];
        $data[] = ['created_at' =>$date,'created_time'=>$time,'user_id'=>$user->id,'role_id'=>3];
        $data[] = ['created_at' =>$date,'created_time'=>$time,'user_id'=>$user->id,'role_id'=>4];

        $result = UserRoleUnion::insert($data);

        if(!$result)
        {
            throw new CommonException('AddDeveloperRoleError');
        }
    }
}
