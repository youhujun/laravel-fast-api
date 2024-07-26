<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 03:07:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 09:56:06
 * @FilePath: \app\Listeners\Admin\User\User\AddUserEvent\AddUserQrcodeListener.php
 */

namespace App\Listeners\Admin\User\User\AddUserEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Picture\Album;
use App\Models\Picture\AlbumPicture;

use App\Models\User\UserQrcode;

use App\Facade\Public\Qrcode\PublicQrcodeFacade;

/**
 * @see \App\Events\Admin\User\User\AddUserEvent
 */
class AddUserQrcodeListener
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
        //第一步先生成二维码
        PublicQrcodeFacade::makeQrcdoeWithUser($user);
        //第二步 存入图片
        $albumPicture = new AlbumPicture;
        $albumPicture->user_id = $user->id;

        $where = [];

        $where[] = ['user_id','=',$user->id];
        $where[] = ['album_type','=',20];

        $album = Album::where($where)->first();

        if(!$album)
        {
            throw new CommonException('admin_code.FindUserAlbumError');
        }

        $albumPicture->album_id = $album->id;
        $albumPicture->created_at = time();
        $albumPicture->created_time = time();
        $albumPicture->picture_name = "{$user->id}_qrcode";
        $albumPicture->picture_path = "/user/album/{$user->id}";
        $albumPicture->picture_size = 30;
        $albumPicture->picture_spec = "300x300";
        $albumPicture->picture_file = "{$user->id}_qrcode.png";

        $albumPictureResult = $albumPicture->save();

        if(!$albumPictureResult)
        {
            throw new CommonException('admin_code.SaveUserQrcodeError');
        }

        //第三步,存入二维码
        $userQrcode = new UserQrcode;
        $userQrcode->user_id = $user->id;
        $userQrcode->album_picture_id =  $albumPicture->id;
        $userQrcode->created_at =  time();
        $userQrcode->created_time =  time();
        $userQrcode->is_default =  1;

        $userQrcodeResult = $userQrcode->save();

        if(!$userQrcodeResult)
        {
            throw new CommonException('admin_code.AddUserQrcodeError');
        }
    }
}
