<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-04 20:46:27
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 21:39:55
 * @FilePath: \app\Listeners\Admin\User\Admin\UpdateAdministratorEvent\UpdateAdministratorRoleListener.php
 */

namespace App\Listeners\Admin\User\Admin\UpdateAdministratorEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\Union\UserRoleUnion;

/**
 * @see \App\Events\Admin\User\Admin\UpdateAdministratorEvent
 */
class UpdateAdministratorRoleListener
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
        $validated = $event->validated;
        $admin = $event->admin;
        $updateAdmin = $event->updateAdmin;

         //定义角色容器
        $roleArray = [];

        //定义数据容器
        $data = [];

        //p($validated['role']);die;

        foreach ($validated['role'] as $key => $value)
        {
            $roleArray[] = $value[0];
        }

        //没有管理员角色
        if (!in_array(1, $roleArray) && !in_array(2, $roleArray) && !in_array(3, $roleArray))
        {
            throw new CommonException('SelectNoAdminRoleError');
        }

        if(!in_array(4, $roleArray))
        {
            throw new CommonException('SelectNoUserRoleError');
        }

        $user_id = $updateAdmin->user->id;

        foreach ($roleArray as $key => $value)
        {
            $data[] = ['created_at' => date('Y-m-d H:i:s',time()), 'created_time' => time(), 'user_id' => $user_id, 'role_id' => $value];
        }

        //先清空用户原来的角色
        $where = [];
        $where[] = ['user_id','=',$user_id];

        $deleteResult = UserRoleUnion::where($where)->delete();

        if(!$deleteResult)
        {
            throw new CommonException('UpdateAdminRoleError');
        }

        $userRoleUnionResult = UserRoleUnion::insert($data);

        if (!$userRoleUnionResult)
        {
            throw new CommonException('UpdateAddAdminRoleError');
        }

    }
}
