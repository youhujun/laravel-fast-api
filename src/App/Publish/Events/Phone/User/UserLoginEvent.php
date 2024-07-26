<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-27 15:57:58
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-27 16:43:14
 * @FilePath: \app\Events\Phone\User\UserLoginEvent.php
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
 * @see \App\Listeners\Phone\User\UserLoginEvent\AddPhoneUserLogListener
 */
class UserLoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $ip;
    // 是否开启事务
    public $isTransation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$ip,$isTransation = 0)
    {
        //
        $this->user = $user;
        $this->ip = $ip;
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
