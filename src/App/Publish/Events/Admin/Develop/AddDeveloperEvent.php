<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 08:04:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 08:31:03
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Events\Admin\Develop\AddDeveloperEvent.php
 */

namespace App\Events\Admin\Develop;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\Admin;
use App\Models\User\User;


/**
 * @see \App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperAdminListener
 * @see \App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperAdminAlbumListener
 * @see \App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserAddressListener
 * @see \App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserAvatarListener
 * @see \App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserinfoListener
 * @see \App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserQrcodeListener
 * @see \App\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserRoleListener
 */
class AddDeveloperEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin;
    public $user;
    public $validated;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,User $user,$validated)
    {
        $this->admin = $admin;
        $this->user = $user;
        $this->validated = $validated;
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
