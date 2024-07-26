<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-08 12:43:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 14:34:06
 * @FilePath: \app\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserQrcodeListener.php
 */

namespace App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use Illuminate\Support\Facades\DB;
use App\Exceptions\Phone\CommonException;

use App\Facade\Public\Qrcode\PublicQrcodeFacade;

use App\Models\User\UserQrcode;
use App\Models\Picture\AlbumPicture;
use App\Models\Picture\Album;
/**
 *@see \App\Events\Phone\User\Wechat\WechatOfficialRegisterEvent
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
        $params = $event->params;
        $isTransation = $event->isTransation;

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
            if($isTransation)
            {
                DB::rollBack();
            }
            throw new CommonException('WechatOfficialFindUserAlbumError');
        }

        $albumPicture->album_id = $album->id;
        $albumPicture->user_id = $user->id;
        $albumPicture->created_at = time();
        $albumPicture->created_time = time();
        $albumPicture->picture_name = "{$user->id}_qrcode";
        $albumPicture->picture_path = "/user/album/{$user->id}";
        $albumPicture->picture_size = 30;
        $albumPicture->picture_spec = "300x300";
        $albumPicture->picture_file = "{$user->id}_qrcode.png";;
        $albumPictureResult = $albumPicture->save();

        if(!$albumPictureResult)
        {
            if($isTransation)
            {
                DB::rollBack();
            }

            throw new CommonException('WechatOfficialSaveUserQrcodeError');
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
            if($isTransation)
            {
                DB::rollBack();
            }

            throw new CommonException('WechatOfficialAddUserQrcodeError');
        }
    }
}
