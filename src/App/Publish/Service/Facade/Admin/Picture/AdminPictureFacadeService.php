<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 02:59:54
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 12:50:34
 * @FilePath: \app\Service\Facade\Admin\Picture\AdminPictureFacadeService.php
 */

namespace App\Service\Facade\Admin\Picture;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Image;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\Picture\Album;
use App\Models\Picture\AlbumPicture;
use App\Models\User\User;
use App\Models\User\UserAvatar;

use App\Http\Resources\System\Picture\AlbumPictureResource;

/**
 * @see \App\Facade\Admin\Picture\AdminPictureFacade
 */
class AdminPictureFacadeService
{
   public function test()
   {
       echo "AdminPictureFacadeService test";
   }

      /**
     * 设置封面
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function setCover($validated ,$admin)
    {
        $result = code(config('admin_code.SetCoverError'));

        $picture_id = $validated['id'];

        $picture = AlbumPicture::find($picture_id);

        if(!$picture)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $album_id = $picture->album_id;

        $album = Album::find($album_id);

        if(!$album)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $revision = $album->revision;

        $updateWhere =  [['id','=', $album_id],['revision','=',$revision]];

        $updateData = [
            'revision'=>$revision + 1,
            'updated_time'=>time(),
            'updated_at'=> date('Y-m-d H:i:s',time()),
            'cover_album_picture_id' =>$picture_id,
        ];

        $updateResult = Album::where( $updateWhere)->update($updateData);

        if(!$updateResult)
        {
            throw new CommonException('SetCoverError');
        }

        CommonEvent::dispatch($admin,['picture_id'=>$picture_id,'data'=>$updateData],'SetCover');

        $result = code(['code'=>0,'msg'=>'设置封面成功']);

        return $result;
    }

     /**
     * 单图片移动相册
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function moveAlbum($validated ,$admin)
    {
        $result = code(config('admin_code.MoveAlbumError'));

        $album_id = $validated['album_id'];

        $picture_id = $validated['picture_id'];

        $picture = AlbumPicture::find( $picture_id);

        if(!$picture)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $updateData = [
            'album_id' => $album_id,
            'revision' =>  $picture->revision + 1,
            'updated_at' => date('Y-m-d H:i:s',time()),
            'updated_time' => time()
        ];

        $updateResult = AlbumPicture::where('id',  $picture_id )->update($updateData);

        if(!$updateResult)
        {
            throw new CommonException('MoveAlbumError');
        }

        CommonEvent::dispatch($admin,$validated,'MoveAlbum');

        $result = code(['code'=>0,'msg'=>'移动相册成功!']);

        return $result;
    }

    /**
     * 相册
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function moveMultipleAlbum($validated ,$admin)
    {
        $result = code(config('admin_code.MoveMultipleAlbumError'));

        $album_id = $validated['album_id'];

        $pictureId = $validated['pictureId'];

        $updateData = [];

        //开始事务
        $pictures = AlbumPicture::whereIn('id',$pictureId)->lockForUpdate()->get();

        DB::beginTransaction();

        $updateData =
            [
                'album_id' => $album_id,
                'updated_at' => date('Y-m-d H:i:s',time()),
                'updated_time' => time()
            ];

        $updateResult = AlbumPicture::whereIn('id', $pictureId)->update($updateData);

        if(!$updateResult)
        {
            DB::rollBack();
            throw new CommonException('MoveMultipleAlbumError');
        }

        CommonEvent::dispatch($admin,$validated,'MoveMultipleAlbum',1);

        DB::commit();

        $result = code(['code'=>0,'msg'=>'批量移动相册成功!']);

        return $result;
    }


    /**
     * 删除图片
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function deletePicture($validated ,$admin)
    {
        $result = code(config('admin_code.DeletePictureError'));

        $picture_id = $validated['picture_id'];

        $picture = AlbumPicture::find($picture_id);

        if(!$picture)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $picture->deleted_time = time();

        $picture->deleted_at = date('Y-m-d H:i:s',time());

        $deleteResult = $picture->save();

        if(!$deleteResult)
        {
            throw new CommonException('DeletePictureError');
        }

        CommonEvent::dispatch($admin,$validated,'DeletePicture');

        $result = code(['code'=>0,'msg'=>'删除图片成功!']);

        return $result;
    }

    /**
     * 批量删除图片
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function deleteMultiplePicture($validated ,$admin)
    {
        $result = code(config('admin_code.DeleteMultiplePictureError'));

        $pictureId = $validated['pictureId'];

        $updateData =
        [
            'deleted_at' => date('Y-m-d H:i:s',time()),
            'deleted_time' => time()
        ];

        $pictures = AlbumPicture::whereIn('id',$pictureId)->lockForUpdate()->get();

        $deleteResult = AlbumPicture::whereIn('id',$pictureId)->update($updateData);

        if( !$deleteResult)
        {
            throw new CommonException('DeleteMultiplePictureError');
        }

        CommonEvent::dispatch($admin,$validated,'DeleteMultiplePicture');

        $result = code(['code'=>0,'msg'=>'批量删除图片成功!']);

        return $result;
    }



    /**
     * 修改图片名称
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updatePictureName($validated ,$admin)
    {
        $result = code(config('admin_code.UpdatePictureNameError'));

        $picture_id = $validated['picture_id'];

        $picture_name = $validated['picture_name'];

        $picture = AlbumPicture::find($picture_id);

        if(!$picture)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $picture->picture_name = $picture_name;

        $picture->updated_time = time();

        $picture->updated_at = time();

        $updateResult = $picture->save();

        if(!$updateResult)
        {
            throw new CommonException('UpdatePictureNameError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdatePictureName');

        $result = code(['code'=>0,'msg'=>'更新图片成功!']);

        return $result;
    }
}
