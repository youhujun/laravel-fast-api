<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-01 20:53:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-02 15:26:42
 * @FilePath: \app\Listeners\Phone\User\UserRegisterEvent\AddUserAvatarListener.php
 */

namespace App\Listeners\Phone\User\UserRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\phone\CommonException;

use App\Models\User\UserAvatar;

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

        $isTransation = $event->isTransation;

        //用户头像
        $userAvatar = new UserAvatar;

        $userAvatar->user_id = $user->id;

        $userAvatar->album_picture_id = 2;

        $userAvatar->created_at = time();

        $userAvatar->created_time = time();

        $userAvatarResult = $userAvatar->save();

        if(!$userAvatarResult)
        {
            if($isTransation)
            {
                 DB::rollBack();
            }
            throw new CommonException('AddUserAvatarError');
        }
    }
}
