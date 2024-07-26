<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-11 09:10:04
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-18 12:31:07
 * @FilePath: \app\Service\Facade\Phone\File\PhonePictureFacadeService.php
 */

namespace App\Service\Facade\Phone\File;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Exceptions\Phone\CommonException;

use App\Events\Phone\CommonEvent;


use App\Models\Picture\Album;
use App\Models\Picture\AlbumPicture;
use App\Models\User\User;
use App\Models\User\UserAvatar;

use App\Facade\Public\Store\QiNiuFacade;

use App\Http\Resources\System\Picture\AlbumPictureResource;

use Image;

/**
 * @see \App\Facade\Phone\File\PhonePictureFacade
 */
class PhonePictureFacadeService
{
   public function test()
   {
       echo "PhonePictureFacadeService test";
   }

   protected static $user_picture_path = DIRECTORY_SEPARATOR.'user'. DIRECTORY_SEPARATOR.'album'.DIRECTORY_SEPARATOR;

   protected static $storage_public_path = DIRECTORY_SEPARATOR.'app'. DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR;

   /**
    * 获取用户默认相册
    *
    * @param [type] $user
    * @return void
    */
   protected function getDefaultAlbum($user)
   {
        $where = [];

        $where[] = ['user_id','=',$user->id];
        $where[] = ['is_default','=',1];

        $defaultAlbum = Album::where($where)->first();

        if(!$defaultAlbum)
        {
            throw new CommonException('GetUserDefaultAlbumError');
        }

        return $defaultAlbum;

   }

   /**
    * 单图上传
    *
    * @param [type] $user
    * @param [type] $picture
    * @return void
    */
   public function singleUploadPicture($user, $picture)
   {
        $result = code(config('phone_code.SinglePictureUploadError'));

        $userDefaultAlbum = $this->getDefaultAlbum($user);

        if(!$userDefaultAlbum)
        {
            throw new CommonException('GetUserDefaultAlbumError');
        }

        $album_id = $userDefaultAlbum->id;

        $user_id = $user->id;

        $insertData = [];

        //图片上传结果设置为1
        if($picture->isValid())
        {
            $picture_file = $picture->getClientOriginalName();

            $picture_path = self::$user_picture_path.$user_id.DIRECTORY_SEPARATOR;

            $path = $picture->storeAs($picture_path,$picture_file,'public');

            $exists = Storage::disk('public')->exists($path);

            if(!$exists)
            {
                throw new CommonException('SinglePictureUploadSaveError');
            }

            $cloudStore = Cache::store('redis')->get('cloud.store');

            if($cloudStore == 'qiniu')
            {
                QiNiuFacade::uploadFile(public_path('storage/'.$path),'storage'.$picture_path.$picture_file);
            }


            $picture_info = getimagesize(storage_path().self::$storage_public_path.$path);
            $picture_name= \pathinfo($path,\PATHINFO_FILENAME);

            $picture_size = round(filesize(storage_path().self::$storage_public_path.$path)/1024,0);
            $picture_spec = "{$picture_info[0]}×{$picture_info[1]}";

            $insertData = [
                'user_id' =>$user_id,
                'album_id'=>$album_id,
                'created_at' => date('Y-m-d H:i:s',time()),
                'created_time' => time(),
                'picture_name' => $picture_name,
                'picture_file' => $picture_file,
                'picture_path' => $picture_path,
                'picture_size' => $picture_size,
                'picture_spec' => $picture_spec,
                'picture_type'=> 10
            ];

            if($cloudStore == 'qiniu')
            {
                $cdnUrl = trim(Cache::store('redis')->get('qiniu.cdn_url'));

                if(!$cdnUrl)
                {
                    throw new CommonException('QiNiuCdnUrlError');
                }

                $insertData['picture_type'] = 20;
                $insertData['picture_url'] = $cdnUrl.'/storage'.$picture_path.$picture_file;
            }


        }

        $insertResult = AlbumPicture::insertGetId($insertData);

        if(!$insertResult)
        {
            throw new CommonException('SinglePictureUploadSqlError');
        }

        CommonEvent::dispatch($user, $insertData,'SingleUploadPicture');

        $result = code(['code'=>0,'msg'=>'图片上传成功!'],['data'=>$insertData,'pictureId'=> $insertResult]);

        return $result;
   }
}
