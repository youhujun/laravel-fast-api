<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 22:58:36
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 23:09:41
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Events\Admin\Login\AdminLogoutEvent.php
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

/**
 * @see \App\Listeners\Admin\Login\AdminLogoutEvent\AdminLogoutLogLitener
 * @see \App\Listeners\Admin\Login\AdminLogoutEvent\ClearAdminCacheListener
 */
class AdminLogoutEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin;
    public $ip;
    public $token;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,$ip,$token)
    {
        $this->admin = $admin;
        $this->ip = $ip;
        $this->token = $token;
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
