<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-10 09:37:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-10 09:54:59
 * @FilePath: \app\Events\Phone\User\UserLogoutEvent.php
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
 * @see \App\Listeners\Phone\User\UserLogoutEvent\AddPhoneUserLogListener
 * @see \App\Listeners\Phone\User\UserLogoutEvent\ClearPhoneUserCacheListener
 */
class UserLogoutEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $ip;
    public $token;
    // 是否开启事务
    public $isTransation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$ip,$token,$isTransation = 0)
    {
        //
        $this->user = $user;
        $this->ip = $ip;
        $this->token = $token;
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
