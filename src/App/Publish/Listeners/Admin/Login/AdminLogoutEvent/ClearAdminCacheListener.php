<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 23:01:30
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 23:25:17
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Listeners\Admin\Login\AdminLogoutEvent\ClearAdminCacheListener.php
 */

namespace App\Listeners\Admin\Login\AdminLogoutEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Redis;
/**
 * @see \App\Events\Admin\Login\AdminLogoutEvent
 */
class ClearAdminCacheListener
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
        $token = $event->token;

        Redis::del("admin_token:{$token}");
        Redis::hdel("admin:admin",$admin->id);
        Redis::hdel("admin_info:admin_info",$admin->id);
        Redis::hdel("admin_roles:admin_roles",$admin->id);
    }
}
