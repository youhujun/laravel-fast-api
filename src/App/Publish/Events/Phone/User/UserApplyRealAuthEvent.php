<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 18:52:16
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-16 10:06:16
 * @FilePath: \app\Events\Phone\User\UserApplyRealAuthEvent.php
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
 * @see \App\Listeners\Phone\User\UserApplyRealAuthEvent\UpdateUserRealAuthStatusListener
 * @see \App\Listeners\Phone\User\UserApplyRealAuthEvent\UpdateUserInfoListener
 * @see \App\Listeners\Phone\User\UserApplyRealAuthEvent\AddUserIdCardListener
 */
class UserApplyRealAuthEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
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
     * 广播事件名称
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'RealAuthApply';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');

        return new Channel('admin_real_auth_apply');
    }
}
