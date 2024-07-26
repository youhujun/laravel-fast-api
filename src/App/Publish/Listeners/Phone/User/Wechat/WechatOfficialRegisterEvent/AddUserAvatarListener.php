<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-08 12:42:43
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 14:33:27
 * @FilePath: \app\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserAvatarListener.php
 */

namespace App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\phone\CommonException;

use App\Models\Picture\Album;
use App\Models\Picture\AlbumPicture;
use App\Models\User\UserAvatar;

/**
 *@see \App\Events\Phone\User\Wechat\WechatOfficialRegisterEvent
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
        $params = $event->params;
        $isTransation = $event->isTransation;

        //用户相册
        $where = [];

        $where[] = ['user_id','=',$user->id];
        $where[] = ['album_type','=',20];

        $album = Album::where($where)->first();

        if(!$album)
        {
            if($isTransation)
            {
                DB::rollBack();
            }
            throw new CommonException('WechatOfficialFindUserAlbumError');
        }

        //头像图片
        $albumPicture = new AlbumPicture;

        $albumPicture->user_id = $user->id;
        $albumPicture->album_id = $album->id;

        $user_avatar_url = '';

        if(isset($params['user_avatar_url']))
        {
            $user_avatar_url = $params['user_avatar_url'];
        }

        $albumPicture->picture_url = $user_avatar_url;
        //微信头像链接
        $albumPicture->picture_type = 30;
        $albumPicture->created_at = time();
        $albumPicture->created_time = time();

        $albumPictureResult = $albumPicture->save();

        if(!$albumPictureResult)
        {
             if($isTransation)
            {
                DB::rollBack();
            }

            throw new CommonException('WechatOfficialAddUserAvatarPictureError');
        }


        //用户头像
        $userAvatar = new UserAvatar;

        $userAvatar->user_id = $user->id;

        $userAvatar->is_default = 1;

        $userAvatar->album_picture_id = $albumPicture->id;

        $userAvatar->created_at = time();

        $userAvatar->created_time = time();

        $userAvatarResult = $userAvatar->save();

        if(!$userAvatarResult)
        {
            if($isTransation)
            {
                 DB::rollBack();
            }
            throw new CommonException('WechatOfficialAddUserAvatarError');
        }
    }
}
