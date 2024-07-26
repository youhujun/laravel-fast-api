<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-04 20:04:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 20:10:06
 * @FilePath: \app\Events\Admin\User\Admin\AddAdministratorEvent.php
 */

namespace App\Events\Admin\User\Admin;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User\User;
use App\Models\Admin\Admin;

/**
 * @see \App\Listeners\Admin\User\Admin\AddAdministratorEvent\AddAdministratorAlbumListener
 * @see \App\Listeners\Admin\User\Admin\AddAdministratorEvent\AddAdministratorRoleListener
 */
class AddAdministratorEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin;
    public $addAdmin;
    public $validated;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,Admin $addAdmin,$validated)
    {
        //
        $this->admin = $admin;
        $this->addAdmin = $addAdmin;
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
