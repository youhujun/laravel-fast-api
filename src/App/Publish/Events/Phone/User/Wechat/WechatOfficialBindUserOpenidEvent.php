<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-08 14:45:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 16:39:24
 * @FilePath: \app\Events\Phone\User\Wechat\WechatOfficialBindUserOpenidEvent.php
 */

namespace App\Events\Phone\User\Wechat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User\User;

/**
 * @see \App\Listeners\Phone\User\Wechat\WechatOfficialBindUserOpenidEvent\WechatOfficialBindUserOpenidListener
 */
class WechatOfficialBindUserOpenidEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $params;
    // 是否开启事务
    public $isTransation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$params,$isTransation = 0)
    {
        //
        $this->user = $user;
        $this->params = $params;
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
