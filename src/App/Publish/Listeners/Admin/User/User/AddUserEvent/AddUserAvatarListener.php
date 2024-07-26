<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 03:05:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 03:16:40
 * @FilePath: \app\Listeners\Admin\User\User\AddUserEvent\AddUserAvatarListener.php
 */

namespace App\Listeners\Admin\User\User\AddUserEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\UserAvatar;

/**
 * @see \App\Events\Admin\User\User\AddUserEvent
 */
class AddUserAvatarListener
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
        $validated = $event->validated;

        //用户头像
        $userAvatar = new UserAvatar;

        $userAvatar->user_id = $user->id;

        $userAvatar->album_picture_id = 2;

        $userAvatar->is_default = 1;

        $userAvatar->created_at = time();
        $userAvatar->created_time = time();

        $userAvatarResult = $userAvatar->save();

        if(!$userAvatarResult)
        {
            throw new CommonException('AddUserAvatarError');
        }
    }
}
