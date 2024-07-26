<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 13:53:41
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 19:22:34
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Events\Admin\Login\AdminLoginEvent.php
 */

namespace App\Events\Admin\Login;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\Admin;

/** 用户登录日志
 * @see \App\Listeners\Admin\Login\AdminLoginEvent\AdminLoginLogListener
 * 存储管理员角色
 * @see \App\Listeners\Admin\Login\AdminLoginEvent\CacheAdminRolesListener
 */
class AdminLoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin;
    public $validated;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,$validated)
    {
        //
        $this->admin = $admin;
        $this->validated = $validated;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
