<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 03:04:18
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 03:14:22
 * @FilePath: \app\Events\Admin\User\User\AddUserEvent.php
 */

namespace App\Events\Admin\User\User;

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
 * @see \App\Listeners\Admin\User\User\AddUserEvent\AddUserAlbumListener
 * @see \App\Listeners\Admin\User\User\AddUserEvent\AddUserAvatarListener
 * @see \App\Listeners\Admin\User\User\AddUserEvent\AddUserInfoListener
 * @see \App\Listeners\Admin\User\User\AddUserEvent\AddUserRoleListener
 * @see \App\Listeners\Admin\User\User\AddUserEvent\AddUserAddressListener
 * @see \App\Listeners\Admin\User\User\AddUserEvent\AddUserQrcodeListener
 */
class AddUserEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $admin;
    public $validated;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,Admin $admin,$validated)
    {
        //
        $this->user = $user;
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
