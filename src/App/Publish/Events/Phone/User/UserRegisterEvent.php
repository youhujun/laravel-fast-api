<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-01 20:52:02
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-02 11:13:41
 * @FilePath: \app\Events\Phone\User\UserRegisterEvent.php
 */

namespace App\Events\Phone\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User\User;

/**
 * @see \App\Listeners\Phone\User\UserRegisterEvent\AddUserInfoListener
 * @see \App\Listeners\Phone\User\UserRegisterEvent\AddUserAlbumListener
 * @see \App\Listeners\Phone\User\UserRegisterEvent\AddUserAvatarListener
 * @see \App\Listeners\Phone\User\UserRegisterEvent\AddUserRoleListener
 * @see \App\Listeners\Phone\User\UserRegisterEvent\AddUserQrcodeListener
 * @see \App\Listeners\Phone\User\UserRegisterEvent\AddUserSourceListener
 */
class UserRegisterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $admin;
    public $validated;
    // 是否开启事务
    public $isTransation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$validated,$isTransation = 0)
    {
        //
        $this->user = $user;
        $this->validated = $validated;
        $this->isTransation = $isTransation;
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
