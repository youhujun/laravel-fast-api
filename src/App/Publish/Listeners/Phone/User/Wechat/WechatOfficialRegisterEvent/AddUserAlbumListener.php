<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-08 14:28:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 14:33:42
 * @FilePath: \app\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserAlbumListener.php
 */

namespace App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Phone\CommonException;

use App\Models\Picture\Album;

/**
 *@see \App\Events\Phone\User\Wechat\WechatOfficialRegisterEvent
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
        $params = $event->params;
        $isTransation = $event->isTransation;

        //用户相册
        $album = new Album;

        $album ->user_id = $user->id;

        $album->created_at = time();

        $album->created_time = time();

        $album->is_default = 1;

        $album->album_name = $user->account_name;

        $album->album_description = $user->account_name;

        $album->sort = 100;

        $album->cover_album_picture_id = 1;

        //暂不保存 相册 先给一个用户相册
        $album->album_type = 20;

        //保存相册
        $albumResult = $album->save();

        if(!$albumResult)
        {
            if($isTransation)
            {
                DB::rollBack();
            }

            throw new CommonException('WechatOfficialAddUserAlbumError');
        }
    }
}
