<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 19:21:28
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-06 00:18:41
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Listeners\Admin\Login\AdminLoginEvent\CacheAdminRolesListener.php
 */

namespace App\Listeners\Admin\Login\AdminLoginEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Exceptions\Admin\CommonException;

use Illuminate\Support\Facades\Redis;

/**
 * @see \App\Events\Admin\Login\AdminLoginEvent
 */
class CacheAdminRolesListener
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
        $validated= $event->validated;

        $rolesArray = $admin->getAdminRoles();

        $result = 0;

        $hasResult = Redis::hget("admin_roles:admin_roles",$admin->id);

        if($hasResult)
        {
            $result = 1;
        }
        else
        {
            if(count($rolesArray))
            {
                $result =  Redis::hset("admin_roles:admin_roles",$admin->id,json_encode($rolesArray));
            }
        }

        if(!$result)
        {
            throw new Commonexception('CacheAdminRolesError');
        }

    }
}
