<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 20:08:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 21:01:14
 * @FilePath: \app\Events\Admin\CommonEvent.php
 */

namespace App\Events\Admin;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\Admin;

/**
 * @see \App\Listeners\Admin\CommonEvent\CommonEventListener
 */
class CommonEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin;
    public $logData;
    public $eventCode;

    //是否开启事务
    public $isTransation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,$logData,$eventCode,$isTransation = 0)
    {
        $this->admin = $admin;
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
