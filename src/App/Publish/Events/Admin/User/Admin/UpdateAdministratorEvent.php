<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-04 20:45:39
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 20:57:36
 * @FilePath: \app\Events\Admin\User\Admin\UpdateAdministratorEvent.php
 */

namespace App\Events\Admin\User\Admin;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\Admin;

/**
 * @see \App\Listeners\Admin\User\Admin\UpdateAdministratorEvent\UpdateAdministratorRoleListener
 */
class UpdateAdministratorEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin;
    public $updateAdmin;
    public $validated;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,Admin $updateAdmin, $validated)
    {
        $this->admin = $admin;
        $this->updateAdmin = $updateAdmin;
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
