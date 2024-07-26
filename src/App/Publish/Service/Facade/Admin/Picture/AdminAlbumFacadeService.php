<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 02:54:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 14:38:08
 * @FilePath: \app\Service\Facade\Admin\Picture\AdminAlbumFacadeService.php
 */

namespace App\Service\Facade\Admin\Picture;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Service\Facade\Trait\QueryService;

use App\Exceptions\Admin\CommonException;
use App\Events\Admin\CommonEvent;

use App\Models\Picture\Album;
use App\Models\Picture\AlbumPicture;
use App\Models\Admin\Admin;
use App\Models\User\User;

use App\Http\Resources\System\Picture\AlbumResource;
use App\Http\Resources\System\Picture\AlbumCollection;
use App\Http\Resources\System\Picture\AlbumPictureCollection;

/**
 * @see \App\Facade\Admin\Picture\AdminAlbumFacade
 */
class AdminAlbumFacadeService
{
   public function test()
   {
       echo "AdminAlbumFacadeService test";
   }

    use QueryService;

    //相册排序
    protected static $sort = [
      1 => ['sort','desc'],
      2 => ['sort','asc'],
      3 => ['created_time','asc'],
      4 => ['created_time','desc']
    ];

    //相册图片排序
    protected static $pictureSort = [
        1 => ['picture_size','desc'],
        2 => ['picture_size','asc'],
        3 => ['created_time','asc'],
        4 => ['created_time','desc']
      ];

    /**
    * 获取默认的管理员相册
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function getDefaultAlbum($validated,$admin)
   {
        $result = code(config('admin_code.GetDefaultAlbumError'));

        $where = [];

        $where[] = ['album_type','=',$validated['album_type']];

        //必定查询系统相册
        $albumList = Album::where($where)->orWhere('album_type',0)->where('is_default',1)->orderBy('sort','desc')->orderBy('created_at','asc')->get();

        if(!optional($albumList))
        {
            throw new CommonException('GetDefaultAlbumError');
        }

        $data['data'] = AlbumResource::collection($albumList);

        $result = code(['code'=>0,'msg'=>'获取默认相册成功!'],$data);

        return  $result;

   }

    /**
     * 搜索查找选项
     *
     * @param [type] $find
     * @return void
     */
    public function findAlbum($validated)
    {
        $result = code(config('admin_code.FindAlbumError'));

        $where = [];

        $where[] = ['album_type','=',$validated['album_type']];

        if(isset($validated['find']) && $validated['find'])
        {
            $where[] = ['album_name','like',"%{$validated['find']}%"];
        }

        $albumList = Album::where($where)->orWhere('album_type',0)->orderBy('sort','desc')->orderBy('created_at','asc')->get();

        if(!optional($albumList))
        {
            throw new CommonException('FindAlbumError');
        }

        $data['data'] = AlbumResource::collection($albumList);

        $result = code(['code'=>0,'msg'=>'查找相册成功!'],$data);

        return  $result;
    }

   /**
   *
   * @param [type] $sortType
   * @param [type] $admin
   * @return void
   */
  public function getAlbum($validated,$admin)
  {
    $result = code(config('admin_admin_code.GetAlbumError'));

    $this->setQueryOptions($validated);

    $sortType = isset($validated['sortType'])?$validated['sortType']:3;

    $admin_id = $admin->id;

    $where = [];
    $orWhere = [];

    $query = Album::with(['coverAlbumPicture']);

    //如果设置相册类型
    if(isset($validated['album_type']))
    {
        $where[] = ['album_type','=',$validated['ablum_type']];

        //如果是管理员查询 管理员
        if($admin->isAdmin())
        {
            $where[] = ['admin_id','=',$admin_id];
        }
    }
    else
    {
        //任何管理员都可以查看用户
        $where[] = ['album_type','=',20];

         //如果是开发者或者超级管理员 查询系统
        if($admin->isDevelop() || $admin->isSuper())
        {
            //查看系统和所有管理员
            $orWhere[] = ['album_type',0];
            $orWhere[] = ['album_type',10];

        }
        else
        {
            //如果是管理员查询 管理员
            if($admin->isAdmin())
            {
                $where[] = ['user_id','=',$admin_id];
                $orWhere[] = ['album_type',10];
            }
        }
    }

    $query->where($where);

    $query = $this->setOrWhere($query,$orWhere);

    if($sortType == '3' || $sortType == '4')
    {
        $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
    }
    else
    {
        $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1])->orderBy('created_time','desc');
    }

    $album = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

    if(\optional($album))
    {
        $result = new AlbumCollection($album,['code'=>0,'msg'=>'查询相册列表成功!']);

    }

    return  $result;

  }

  /**
 * 添加相册
 *
 * @param [type] $validated
 * @param [type] $admin
 * @return void
 */
   public function addAlbum($validated,$admin)
   {
        $result = code(config('admin_admin_code.AddAlbumError'));

        $album = new Album;

        foreach ( $validated as $key => $value)
        {
            if(is_null($value))
            {
                $value = "";
            }

            if($key == 'album_type' )
            {
                if($value == 0)
                {
                    $album->is_system = 1;
                }

                if($value == 20)
                {
                    $album ->user_id = $admin->user->id;
                }

            }

            $album->$key = $value;
        }

        //图片封面默认
        $album ->cover_album_picture_id = 1;

        $album ->admin_id = $admin->id;

        $album->created_time = time();
        $album->created_at = time();

        $albumResult = $album->save();

        if(!$albumResult)
        {
           throw new CommonException('AddAlbumError');
        }

        CommonEvent::dispatch($admin,$validated,'AddAlbum');

        //控制相册是否包含图片加载
        //AlbumResource::setWithPicture(1);

        $data['data'] =  new AlbumResource($album);

        $result = code(['code'=>0,'msg'=>'添加相册成功'],$data);

        return  $result;
   }

   /**
    * 更新相册
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function updateAlbum($validated,$admin)
   {
        $result = code(config('admin_admin_code.UpdateAlbumError'));

        $album = Album::find($validated['id']);

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$album->revision];

        foreach ( $validated as $key => $value)
        {
            if($key === 'id')
            {
                $where[] = ['id','=',$value];
                continue;
            }

            if($key == 'album_type')
            {
                if($value == 0)
                {
                    $updateData['is_system'] = 1;
                }
                else
                {
                    $updateData['is_system'] = 0;
                }
            }

            if(\is_null($value))
            {
                $value = "";
            }

            $updateData[$key] = $value;
        }

        $updateData['revision'] = $album ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $updateResult = Album::where($where)->update($updateData);

        if(!$updateResult)
        {
           throw new CommonException('UpdateAlbumError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdateAlbum');

        $album = Album::find($validated['id']);

        $data['data'] =  new AlbumResource($album);

        $result = code(['code'=>0,'msg'=>'更新相册成功'],['data'=>$data]);

        return  $result;
   }

   /**
    * 删除相册
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function deleteAlbum($validated,$admin)
   {
     $result = code(config('admin_admin_code.DeleteAlbumError'));

     $album = Album::find($validated['id']);

     if(!$album)
     {
        throw new CommonException('ThisDataNotExistsError');
     }

     if($album->is_system)
     {
        throw new CommonException('ThisAlbumIsSystemError');
     }

     //相册图片数量
     $albumPictureNumber = $album->albumPicture->count();

     //如果有图片需要先将图片转移到默认相册
     if($albumPictureNumber)
     {
        $albumPicture = $album->getRelation('albumPicture');

        //要转移相册图片容器
        $pictureId = [];

        foreach ($albumPicture as $key => $value)
        {
            $pictureId[] = $value['id'];
        }

        $defaultAlbum = null;

        //根据删除的系统相册类型获取默认相册
        if($album->album_type == 0 )
        {
            $defaultAlbum = Album::where('album_type',0)->where('is_system',1)->first();
        }

        if($album->album_type == 10 )
        {
            $defaultAlbum = Album::where('album_type',10)->where('is_system',1)->where('admin_id',$album->admin_id)->first();
        }

        if($album->album_type == 20 )
        {
            $defaultAlbum = Album::where('album_type',20)->where('is_system',1)->where('user_id',$album->user_id)->first();
        }

        if(!$defaultAlbum)
        {
            throw new CommonException('ThisSystemAlbumNotExistsError');
        }

        //开始事务
        DB::beginTransaction();

        //启用悲观锁
        $pictures = AlbumPicture::whereIn('id',$pictureId)->lockForUpdate()->get();

        if($album->album_type == 10 || $album->album_type == 0)
        {

            $updateData['admin_id'] = $album->admin_id;
        }

        if($album->album_type == 20)
        {
            $updateData['user_id'] = $album->user_id;
        }

        $updateData =
        [
            'album_id' => $defaultAlbum->id,
            'updated_at' => date('Y-m-d H:i:s',time()),
            'updated_time' => time()
        ];

        $updateResult = AlbumPicture::whereIn('id', $pictureId)->update($updateData);

        if(!$updateResult)
        {
            //回滚
            DB::rollBack();
            throw new CommonException('DeleteAlbumMovePictureError');
        }

        CommonEvent::dispatch($admin,$validated,'MoveDeleteAlbumPicture',1);

     }

     $album->deleted_at = time();
     $album->deleted_time = time();

     $deleteResult = $album->save();

     if(!$deleteResult)
     {
        //回滚
        DB::rollBack();
        throw new CommonException('DeleteAlbumError');
     }

     CommonEvent::dispatch($admin,$validated,'DeleteAlbum',1);

     DB::commit();

     $result = code(['code'=>0,'msg'=>'删除相册成功']);

     return  $result;
   }

   /**
    * 获取相册图片
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function getAlbumPicture($validated,$admin)
   {
        $result = code(config('admin_admin_code.GetAlbumPictureError'));

        $this->setQueryOptions($validated);

        $admin_id = $admin->id;

        $where = [];
        $orWhere = [];

        $sortType = $validated['sortType'];

        if(!isset($validated['sortType']) || $validated['sortType'] == 0)
        {
            $sortType =3;
        }

        $where[] = ['album_id','=',$validated['id']];

        $query = AlbumPicture::where($where);

        //查询该相册
        $album = Album::find($validated['id']);

        //如果相册类型是管理员相册 并且登录用户只是普通管理员 那么只能查看他自己的所属图片
        if(!$admin->isDevelop() && !$admin->isSuper() && $album->album_type == 10)
        {
            $newWhere = [];
            $newWhere[] = ['admin_id','=',$admin_id];
            $query->where($newWhere);
        }

        $query->orderBy(self::$pictureSort[$sortType][0],self::$pictureSort[$sortType][1]);

        //如果是 1或 2是根据 图片大小排序 可以再加上时间排序
        if($sortType == 1 || $sortType == 2)
        {
            $query->orderBy('created_time','desc');
        }

        $pictureList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(\optional($pictureList))
        {
            $result = new AlbumPictureCollection($pictureList,['code'=>0,'msg'=>'获取相册图片成功']);
        }

        return  $result;
   }
}
