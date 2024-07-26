<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-26 14:53:07
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 19:40:18
 * @FilePath: \app\Events\Admin\User\User\SetUserAccountEvent.php
 */

namespace App\Events\Admin\User\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\Admin;

/**
 * @see \App\Listeners\Admin\User\User\SetUserAccountEvent\AddUserAccountLogListener
 */
class SetUserAccountEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $admin;
    public $validated;
    //是否开启事务
    public $isTransation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,$validated,$isTransation = 0)
    {
        $this->admin = $admin;
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
