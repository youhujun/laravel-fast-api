<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 08:11:05
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 21:35:22
 * @FilePath: \app\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperAdminAlbumListener.php
 */

namespace App\Listeners\Admin\Develop\AddDeveloperEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Picture\Album;

/**
 * @see  \App\Events\Admin\Develop\AddDeveloperEvent
 */
class AddDeveloperAdminAlbumListener
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
        $admin = $event->admin;
        $user = $event->user;
        $validated = $event->validated;

        $albumData = [];

        $albumData[] = [
            'admin_id'=>$admin->id,
            'user_id'=> 0,
            'is_default'=>1,
            'album_name'=>'admin_'.$user->account_name,
            'album_description'=>$user->account_name,
            'sort'=>100,
            'cover_album_picture_id'=>1,
            'album_type'=> 10,
            'created_at'=>date('Y-m-d H:i:s',time()),
            'created_time'=>time()
        ];

        $albumData[] = [
            'admin_id'=>0,
            'user_id'=> $user->id,
            'is_default'=>1,
            'album_name'=>'user_'.$user->account_name,
            'album_description'=>$user->account_name,
            'sort'=>100,
            'cover_album_picture_id'=>1,
            'album_type'=> 20,
            'created_at'=>date('Y-m-d H:i:s',time()),
            'created_time'=>time()
        ];

        $result = Album::insert($albumData);

        if(!$result)
        {
            throw new CommonException('AddDeveloperAlbumError');
        }

    }
}
