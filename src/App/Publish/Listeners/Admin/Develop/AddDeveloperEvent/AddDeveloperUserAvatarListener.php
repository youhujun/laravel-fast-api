<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 08:11:27
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 21:45:28
 * @FilePath: \app\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserAvatarListener.php
 */

namespace App\Listeners\Admin\Develop\AddDeveloperEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\UserAvatar;

/**
 * @see \App\Events\Admin\Develop\AddDeveloperEvent
 */
class AddDeveloperUserAvatarListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        $admin = $event->admin;
        $validated = $event->validated;

        //用户头像
        $userAvatar = new UserAvatar;

        $userAvatar->user_id = $user->id;

        $userAvatar->album_picture_id = 2;

        //设置为默认头像
        $userAvatar->is_default = 1;

        $userAvatar->created_at = time();
        $userAvatar->created_time = time();

        $result = $userAvatar->save();

        if(!$result)
        {
            throw new CommonException('AddDeveloperAvatarError');
        }
    }
}
