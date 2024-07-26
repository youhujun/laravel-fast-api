<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-02 10:40:06
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-15 19:10:13
 * @FilePath: \app\Events\Phone\CommonEvent.php
 */

namespace App\Events\Phone;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User\User;

/**
 * @see \App\Listeners\Phone\CommonEvent\CommonEventListener
 */
class CommonEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $logData;
    public $eventCode;
    // 是否开启事务
    public $isTransation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$logData,$eventCode,$isTransation = 0)
    {
        //
        $this->user = $user;
        $this->logData = $logData;
        $this->eventCode = $eventCode;
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
