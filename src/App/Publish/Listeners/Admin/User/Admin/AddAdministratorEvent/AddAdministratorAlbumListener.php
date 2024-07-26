<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-04 20:06:58
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 20:08:49
 * @FilePath: \app\Listeners\Admin\User\Admin\AddAdministratorEvent\AddAdministratorAlbumListener.php
 */

namespace App\Listeners\Admin\User\Admin\AddAdministratorEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Picture\Album;

/**
 * @see \App\Events\Admin\User\Admin\AddAdministratorEvent
 */
class AddAdministratorAlbumListener
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
        $addAdmin = $event->addAdmin;
        $validated = $event->validated;

        $albumData = [];

        $albumData[] = [
            'admin_id'=> $addAdmin->id,
            'is_default'=>1,
            'album_name'=>'admin_'.$addAdmin->account_name,
            'album_description'=>'admin_'.$addAdmin->account_name,
            'sort'=>100,
            'cover_album_picture_id'=>1,
            'album_type'=> 10,
            'created_at'=>date('Y-m-d H:i:s',time()),
            'created_time'=>time()
        ];

        $albumResult = Album::insert($albumData);

        if(!$albumResult)
        {
            throw new CommonException('AddAdminAlbumError');
        }
    }
}
