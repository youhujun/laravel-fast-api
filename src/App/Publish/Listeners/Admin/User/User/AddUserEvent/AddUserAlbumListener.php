<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 03:05:28
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 04:07:57
 * @FilePath: \app\Listeners\Admin\User\User\AddUserEvent\AddUserAlbumListener.php
 */

namespace App\Listeners\Admin\User\User\AddUserEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Picture\Album;

/**
 * @see \App\Events\Admin\User\User\AddUserEvent
 */
class AddUserAlbumListener
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

        //用户相册
        $album = new Album;

        $album ->user_id = $user->id;

        $album->is_default = 1;

        $album->album_name = 'user_'.$user->account_name;
        $album->album_description = $user->account_name;
        $album->sort = 100;
        $album->cover_album_picture_id = 1;

        //暂不保存 相册 先给一个用户相册
        $album->album_type = 20;

        $album->created_at = time();
        $album->created_time = time();

        //保存相册
        $albumResult = $album->save();

        if(!$albumResult)
        {
            throw new CommonException('AddUserAlbumError');
        }
    }
}
