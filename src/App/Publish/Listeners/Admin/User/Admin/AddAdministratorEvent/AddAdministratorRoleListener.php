<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-04 20:07:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 20:36:43
 * @FilePath: \app\Listeners\Admin\User\Admin\AddAdministratorEvent\AddAdministratorRoleListener.php
 */

namespace App\Listeners\Admin\User\Admin\AddAdministratorEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\Union\UserRoleUnion;


/**
 * @see \App\Events\Admin\User\Admin\AddAdministratorEvent
 */
class AddAdministratorRoleListener
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
        $addAdmin = $event->addAdmin;
        $validated = $event->validated;

         //定义角色容器
        $roleArray = [];

        //定义数据容器
        $data = [];

        foreach ($validated['role'] as $key => $value)
        {
            $roleArray[] = $value[0];
        }

        //没有管理员角色
        if (!in_array(1, $roleArray) && !in_array(2, $roleArray) && !in_array(3, $roleArray))
        {
            throw new CommonException('SelectNoAdminRoleError');
        }

        foreach ($roleArray as $key => $value)
        {
            $data[] = ['created_at' => date('Y-m-d H:i:s',time()), 'created_time' => time(), 'user_id' => $validated['user_id'], 'role_id' => $value];
        }

        $userRoleUnionResult = UserRoleUnion::insert($data);

        if (!$userRoleUnionResult)
        {
            throw new CommonException('AddAdminRoleError');
        }

    }
}
