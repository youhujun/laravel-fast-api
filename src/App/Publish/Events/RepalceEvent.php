<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-21 19:14:54
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 19:15:16
 * @FilePath: \app\Events\RepalceEvent.php
 */

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User\User;
use App\Models\Admin\Admin;

class RepalceEvent implements ShouldBroadcast
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
    public function __construct(User $user,Admin $admin,$validated,$isTransation = 0)
    {
        //
        $this->user = $user;
        $this->admin = $admin;
        $this->validated = $validated;
        $this->isTransation = $isTransation;
    }

	/**
     * 广播事件名称
     *
     * @return string
     */
     public function broadcastAs()
    {
        return 'replaceEventName';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');

		// return new Channel('channel-name');
    }
}
