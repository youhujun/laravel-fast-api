<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-08 12:39:39
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 16:33:18
 * @FilePath: \app\Events\Phone\User\Wechat\WechatOfficialRegisterEvent.php
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
 *@see  \App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserInfoListener
 *@see  \App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserAlbumListener
 *@see  \App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserAvatarListener
 *@see  \App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserRoleListener
 *@see  \App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserQrcodeListener
 */
class WechatOfficialRegisterEvent
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
