<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-20 23:10:20
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-18 12:51:02
 * @FilePath: \app\Service\Facade\Admin\File\AdminUploadFacadeService.php
 */

namespace App\Service\Facade\Admin\File;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;
use App\Events\Admin\File\UploadFileEvent;

//模型
use App\Models\Picture\Album;
use App\Models\Picture\AlbumPicture;
use App\Models\User\UserAvatar;

use App\Facade\Public\Store\QiNiuFacade;

//响应
use App\Http\Resources\System\Picture\AlbumPictureResource;
/**
 * @see \App\Facade\Admin\File\AdminUploadFacade
 */
class AdminUploadFacadeService
{
   public function test()
   {
       echo "AdminUploadFacadeService test";
   }

   protected $adminId = 0;

   //根据前端 $validate['use_type] 来决定配置还是管理员配置还是用户\
   protected static $adminTypeDirectory = [
        //系统配置
        '10'=>DIRECTORY_SEPARATOR.'config'. DIRECTORY_SEPARATOR.'file'. DIRECTORY_SEPARATOR,
        // 后台管理员
        '20'=>DIRECTORY_SEPARATOR.'admin'. DIRECTORY_SEPARATOR.'file'. DIRECTORY_SEPARATOR,
        //用户
        '30'=>DIRECTORY_SEPARATOR.'user'. DIRECTORY_SEPARATOR.'file'. DIRECTORY_SEPARATOR
   ];

   //文件存储路径
   protected $filePath;

   //动作类型 配置文件导入,例如银行导入 Bank
   protected $actionType;

   /**
    * 处理文件存储路径
    *
    * @param [type] $validated
    * @return void
    */
   protected function makeSavePath($validated,$admin,$file)
   {
        //文件使用性质类型
        $useType = $validated['use_type'];
        //文件格式类型
        $fileType = $validated['file_type'];
        //文件存储目录
        $savePath = $validated['save_path'];

        //后缀名 xlsx
        $file_extension = $file->getClientOriginalExtension();

        //定义拼接目录 默认使用自动获取的文件名后缀
        $joinPath = $file_extension;

        //如果设置了文件格式类型 二级优先采用 文件格式目录
        if(isset($fileType) && !empty($fileType))
        {
            $joinPath = $fileType;
        }

        //如果设置了存储目录  一级优先采用文件存储目录
        if(isset($savePath) && !empty($savePath))
        {
            $joinPath = $savePath;
        }

        //部分路径 \user\file1\
        $this->filePath = self::$adminTypeDirectory[$useType].$joinPath;

        //如果不是平台配置 需要加上用户id
        if($useType != 10)
        {
            $this->filePath = self::$adminTypeDirectory[$useType].$admin->id.DIRECTORY_SEPARATOR.$joinPath;
        }
   }

   /**
    * 后台上传配置文件
    *
    * @param [type] $validated  [use_type,]
    * @param [type] $admin
    * @param [type] $file
    * @return void
    */
   public function uploadConfigFile($validated,$admin,$file)
   {
        $result = code(config('admin_code.UploadConfigFileError'));

        if(!$file->isValid())
        {
            throw new CommonException('uploadConfigFileAllowError');
        }

        //处理保存路径
        $this->makeSavePath($validated,$admin,$file);

        //后缀名
        $fileType = $file->getClientOriginalExtension();
        //文件名带后缀 template.xlsx
        $file_file =$file->getClientOriginalName();

        //全路径  storage/app/public下
        // config/file/pem/apiclient_key.pem
        // admin/file/4/pem//apiclient_key.pem
        $path =$file->storeAs($this->filePath,$file_file,'public');

        //保存玩以后再检测
        $exists = Storage::disk('public')->exists($path);

        if(!$exists)
        {
            throw new CommonException('UploadConfigFileSaveError');
        }

        $this->actionType = isset($validated['type'])?$validated['type']:'';

        //上传文件数据容器
        $uploadFileLogData = [];
        //文件名 template
        $uploadFileLogData['admin_id'] = $admin->id;
        $uploadFileLogData['use_type'] = $validated['use_type'];
        $uploadFileLogData['file_path'] =$this->filePath;
        $uploadFileLogData['file_extension'] = $fileType;
        $uploadFileLogData['file_name'] = pathinfo($path,\PATHINFO_FILENAME);
        $uploadFileLogData['file'] = $file_file;

        //记录事件日志
        CommonEvent::dispatch($admin,$uploadFileLogData,'UploadConfigFile');

        /**
         * $path 文件位置
         * $this->$actionType 操作类型 例如 bank配合后端导入数据
         * $fileType 后缀名
         */
        UploadFileEvent::dispatch($admin, $uploadFileLogData,$path, $fileType,$this->actionType);

        $result = code(['code'=>0,'msg'=>'上传配置文件成功!'],['data'=>$path]);

        return $result;
   }

   /**
    * 上传文件
    *
    * @param [type] $validated
    * @param [type] $admin
    * @param [type] $file
    * @return void
    */
   public function uploadFile($validated ,$admin, $file)
   {
       $result = code(config('admin_code.UploadFileError'));

        if(!$file->isValid())
        {
            throw new CommonException('UploadFileAllowError');
        }

        //处理保存路径
        $this->makeSavePath($validated,$admin,$file);

        //后缀名
        $fileType = $file->getClientOriginalExtension();
        //文件名带后缀 template.xlsx
        $file_file =$file->getClientOriginalName();

        //全路径  storage/app/public下
        // config/file/pem/apiclient_key.pem
        // admin/file/4/pem//apiclient_key.pem
        $path =$file->storeAs($this->filePath,$file_file,'public');

        //保存玩以后再检测
        $exists = Storage::disk('public')->exists($path);

        if(!$exists)
        {
            throw new CommonException('UploadFileSaveError');
        }

        $this->actionType = isset($validated['type'])?$validated['type']:'';

        //上传文件数据容器
        $uploadFileLogData = [];
        //文件名 template
        $uploadFileLogData['admin_id'] = $admin->id;
        $uploadFileLogData['use_type'] = $validated['use_type'];
        $uploadFileLogData['file_path'] =$this->filePath;
        $uploadFileLogData['file_extension'] = $fileType;
        $uploadFileLogData['file_name'] = pathinfo($path,\PATHINFO_FILENAME);
        $uploadFileLogData['file'] = $file_file;

        //记录事件日志
        CommonEvent::dispatch($admin,$uploadFileLogData,'UploadFile');
        /**
         * $path 文件位置
         * $this->$actionType 操作类型 例如 bank配合后端导入数据
         * $fileType 后缀名
         */
        UploadFileEvent::dispatch($admin, $uploadFileLogData,$path, $fileType,$this->actionType);

        $result = code(['code'=>0,'msg'=>'上传文件成功!'],['data'=>asset('storage/'.$path)]);

        return $result;
   }

    /**
     * 单图上传
     *
     * @param [type] $validated
     * @param [type] $admin
     * @param [type] $pictures
     * @return void
     */
    public function UploadSinglePicture( $validated ,$admin, $picture)
    {
        $result = code(config('admin_code.UploadSinglePictureError'));

        $album_id = $validated['id'];

        //如果没有相册id 就把图片存入到默认相册下
        if($album_id == 0 || !isset($album_id))
        {
            $where = [];
            $where[] = ['album_type','=',0];
            $where[] = ['is_default','=',1];
            $album = Album::where($where)->first();

            if(!$album)
            {
                throw new CommonException('ThisUserHasNoDefaultAlbumError');
            }

            $album_id = $album->id;
        }

        $admin_id = $admin->id;

        if(!$picture->isValid())
        {
            throw new CommonException('UploadSinglePictureAllowError');
        }

        //处理保存路径
        $this->makeSavePath($validated,$admin,$picture);
        //后缀名
        $fileType = $picture->getClientOriginalExtension();
        //文件名带后缀 template.xlsx
        $file_file = $picture->getClientOriginalName();
        //全路径  storage/app/public下
        // config/file/pem/apiclient_key.pem
        // admin/file/4/pem//apiclient_key.pem
        $path =$picture->storeAs($this->filePath,$file_file,'public');
        //保存以后再检测
        $exists = Storage::disk('public')->exists($path);

        if(!$exists)
        {
            throw new CommonException('UploadSinglePictureSaveError');
        }

        $cloudStore = Cache::store('redis')->get('cloud.store');

        if($cloudStore == 'qiniu')
        {
            QiNiuFacade::uploadFile(public_path('storage/'.$path),'storage'.$this->filePath.$file_file);
        }

        $picture_info = getimagesize(storage_path('app/public/').$path);
        $picture_name= \pathinfo($path,\PATHINFO_FILENAME);

        $picture_size = round(filesize(storage_path('app/public/').$path)/1024,0);
        $picture_spec = "{$picture_info[0]}×{$picture_info[1]}";

        //声明数据容器
        $insertData = [];

        $insertData = [
            'admin_id' =>$admin_id,
            'album_id'=>$album_id,
            'picture_name' => $picture_name,
            'picture_file' => $file_file,
            'picture_path' => $this->filePath,
            'picture_size' => $picture_size,
            'picture_spec' => $picture_spec,
            'picture_type' => 10,
            'created_at' => date('Y-m-d H:i:s',time()),
            'created_time' => time(),
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


        $insertId = AlbumPicture::insertGetId($insertData);

        if(!$insertId)
        {
            throw new CommonException('UploadSinglePictureSqlSaveError');
        }

        $albumPictrue = AlbumPicture::find($insertId);

        $this->actionType = isset($validated['type'])?$validated['type']:'';

        //上传文件数据容器
        $uploadFileLogData = [];
        //文件名 template
        $uploadFileLogData['admin_id'] = $admin->id;
        $uploadFileLogData['use_type'] = $validated['use_type'];
        $uploadFileLogData['file_path'] =$this->filePath;
        $uploadFileLogData['file_extension'] = $fileType;
        $uploadFileLogData['file_name'] = pathinfo($path,\PATHINFO_FILENAME);
        $uploadFileLogData['file'] = $file_file;

        CommonEvent::dispatch($admin, $insertData,'UploadSinglePicture');

        /**
         * $path 文件位置
         * $this->$actionType 操作类型 例如 bank配合后端导入数据
         * $fileType 后缀名
         */
        UploadFileEvent::dispatch($admin, $uploadFileLogData,$path, $fileType,$this->actionType);

        $result = code(['code'=>0,'msg'=>'上传单图片成功!'],['data'=>new AlbumPictureResource($albumPictrue)]);

        return $result;
    }

    /**
     * 多图上传
     *
     * @param [type] $validated
     * @param [type] $admin
     * @param [type] $pictures
     * @return void
     */
    public function uploadMultiplePicture( $validated ,$admin, $pictures)
    {
        $result = code(config('admin_code.UploadMultiplePictureError'));

        $album_id = $validated['id'];

        //如果没有相册id 就把图片存入到默认相册下
        if($album_id == 0 || !isset($album_id))
        {
            $where = [];
            $where[] = ['album_type','=',0];
            $where[] = ['is_default','=',1];
            $album = Album::where($where)->first();

            if(!$album)
            {
                throw new CommonException('ThisUserHasNoDefaultAlbumError');
            }

            $album_id = $album->id;
        }

        $admin_id = $admin->id;

        //声明图片容器
        $insertData = [];

         //上传文件数据容器
        $uploadFileLogData = [];

        foreach($pictures as $k => $picture)
        {
            if(!$picture->isValid())
            {
                throw new CommonException('UploadMultiplePictureAllowError');
            }

            //处理保存路径
            $this->makeSavePath($validated,$admin,$picture);
            //后缀名
            $fileType = $picture->getClientOriginalExtension();
            //文件名带后缀 template.xlsx
            $file_file = $picture->getClientOriginalName();
            //全路径  storage/app/public下
            // config/file/pem/apiclient_key.pem
            // admin/file/4/pem//apiclient_key.pem
            $path =$picture->storeAs($this->filePath,$file_file,'public');
            //保存以后再检测
            $exists = Storage::disk('public')->exists($path);

            if(!$exists)
            {
                throw new CommonException('UploadMultiplePictureSaveError');
            }

            $cloudStore = Cache::store('redis')->get('cloud.store');

            if($cloudStore == 'qiniu')
            {
                QiNiuFacade::uploadFile(public_path('storage/'.$path),'storage'.$this->filePath.$file_file);
            }

            $picture_info = getimagesize(storage_path('app/public/').$path);
            $picture_name= \pathinfo($path,\PATHINFO_FILENAME);

            $picture_size = round(filesize(storage_path('app/public/').$path)/1024,0);
            $picture_spec = "{$picture_info[0]}×{$picture_info[1]}";

            $insertData[$k] = [
                'admin_id' =>$admin_id,
                'album_id'=>$album_id,
                'picture_name' => $picture_name,
                'picture_file' => $file_file,
                'picture_path' => $this->filePath,
                'picture_size' => $picture_size,
                'picture_spec' => $picture_spec,
                'picture_type' => 10,
                'created_at' => date('Y-m-d H:i:s',time()),
                'created_time' => time(),
            ];

            if($cloudStore == 'qiniu')
            {
                $cdnUrl = trim(Cache::store('redis')->get('qiniu.cdn_url'));

                if(!$cdnUrl)
                {
                    throw new CommonException('QiNiuCdnUrlError');
                }

                $insertData[$k]['picture_type'] = 20;
                $insertData[$k]['picture_url'] = $cdnUrl.'/storage'.$picture_path.$picture_file;
            }

            //文件名 template
            $uploadFileLogData[$k]['admin_id'] = $admin->id;
            $uploadFileLogData[$k]['use_type'] = $validated['use_type'];
            $uploadFileLogData[$k]['file_path'] =$this->filePath;
            $uploadFileLogData[$k]['file_extension'] = $fileType;
            $uploadFileLogData[$k]['file_name'] = pathinfo($path,\PATHINFO_FILENAME);
            $uploadFileLogData[$k]['file'] = $file_file;

        }

        $insertResult = AlbumPicture::insert($insertData);

        if(!$insertResult)
        {
            throw new CommonException('UploadMultiplePictureSqlSaveError');
        }

        $this->actionType = isset($validated['type'])?$validated['type']:'';

        CommonEvent::dispatch($admin, $insertData,'UploadMultiplePicture');

        /**
         * $path 文件位置
         * $this->$actionType 操作类型 例如 bank配合后端导入数据
         * $fileType 后缀名
         */
        UploadFileEvent::dispatch($admin, $uploadFileLogData,$path, $fileType,$this->actionType,20);

        //这里要再把刚刚添加的图片查询出来
        $where = [];
        $where[] = ['admin_id','=',$admin_id];
        $where[] = ['album_id','=',$album_id];

        $insertPictureList =  AlbumPicture::where($where)->orderBy('created_time','desc')->limit(count($insertData))->get();

        $result = code(['code'=>0,'msg'=>'上传多图成功!'],['data'=>AlbumPictureResource::collection($insertPictureList)]);

        return $result;
    }


    /**
     * 上传头像
     *
     * @param [type] $validated
     * @param [type] $admin
     * @param [type] $picture
     * @return void
     */
    public function uploadUserAvatar($validated ,$admin, $picture)
    {
        $result = code(config('admin_code.UploadUserAvatarError'));

        $album_id = $validated['id'];

        //如果没有相册id 就把图片存入到默用户认相册下
        if($album_id == 0 || !isset($album_id))
        {
            $where = [];
            $where[] = ['album_type','=',20];
            $where[] = ['user_id','=',$validated['user_id']];
            $where[] = ['is_default','=',1];
            $album = Album::where($where)->first();

            if(!$album)
            {
                throw new CommonException('ThisUserHasNoDefaultAlbumError');
            }

            $album_id = $album->id;
        }

        $admin_id = $admin->id;

        $user_id = $validated['user_id'];

        if(!$picture->isValid())
        {
            throw new CommonException('UploadSinglePictureAllowError');
        }

        //处理保存路径
        $this->makeSavePath($validated,$admin,$picture);
        //后缀名
        $fileType = $picture->getClientOriginalExtension();
        //文件名带后缀 template.xlsx
        $file_file = $picture->getClientOriginalName();
        //全路径  storage/app/public下
        // config/file/pem/apiclient_key.pem
        // admin/file/4/pem//apiclient_key.pem
        $path =$picture->storeAs($this->filePath,$file_file,'public');
        //保存以后再检测
        $exists = Storage::disk('public')->exists($path);

        if(!$exists)
        {
            throw new CommonException('UploadSinglePictureSaveError');
        }

        $cloudStore = Cache::store('redis')->get('cloud.store');

        if($cloudStore == 'qiniu')
        {
            QiNiuFacade::uploadFile(public_path('storage/'.$path),'storage'.$this->filePath.$file_file);
        }

        $picture_info = getimagesize(storage_path('app/public/').$path);
        $picture_name= \pathinfo($path,\PATHINFO_FILENAME);

        $picture_size = round(filesize(storage_path('app/public/').$path)/1024,0);
        $picture_spec = "{$picture_info[0]}×{$picture_info[1]}";

        //声明数据容器
        $insertData = [];

        $insertData = [
            'admin_id' =>0,
            'user_id'=>$user_id,
            'album_id'=>$album_id,
            'picture_name' => $picture_name,
            'picture_file' => $file_file,
            'picture_path' => $this->filePath,
            'picture_size' => $picture_size,
            'picture_spec' => $picture_spec,
            'picture_type' => 10,
            'created_at' => date('Y-m-d H:i:s',time()),
            'created_time' => time(),
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

        $insertId = AlbumPicture::insertGetId($insertData);

        if(!$insertId)
        {
            throw new CommonException('UploadSinglePictureSqlSaveError');
        }

        $albumPictrue = AlbumPicture::find($insertId);

        $oldDefaultAvatar = UserAvatar::where('user_id',$user_id)->where('is_default',1)->first();

        if($oldDefaultAvatar)
        {
            $oldDefaultAvatar->is_default = 0;
            $oldDefaultAvatar->save();
        }

        $userAvatar = new UserAvatar;

        $userAvatar->user_id = $validated['user_id'];
        $userAvatar->album_picture_id = $insertId;
        $userAvatar->created_at = time();
        $userAvatar->created_time = time();
        $userAvatar->is_default = 1;

        $userAvatarResult = $userAvatar->save();

        if(!$userAvatarResult)
        {
            throw new CommonException('UploadUserAvatarSaveError');
        }

        $this->actionType = isset($validated['type'])?$validated['type']:'';

        //上传文件数据容器
        $uploadFileLogData = [];
        //文件名 template
        $uploadFileLogData['admin_id'] = $admin->id;
        $uploadFileLogData['use_type'] = $validated['use_type'];
        $uploadFileLogData['file_path'] =$this->filePath;
        $uploadFileLogData['file_extension'] = $fileType;
        $uploadFileLogData['file_name'] = pathinfo($path,\PATHINFO_FILENAME);
        $uploadFileLogData['file'] = $file_file;

        CommonEvent::dispatch($admin, $insertData,'UploadUserAvatar');

        /**
         * $path 文件位置
         * $this->$actionType 操作类型 例如 bank配合后端导入数据
         * $fileType 后缀名
         */
        UploadFileEvent::dispatch($admin, $uploadFileLogData,$path, $fileType,$this->actionType);

        $result = code(['code'=>0,'msg'=>'上传头像成功!'],['data'=>new AlbumPictureResource($albumPictrue)]);

        return $result;

    }

    /**
     * 上传替换图片
     *
     * @param [type] $validated
     * @param [type] $admin
     * @param [type] $pictures
     * @return void
     */
    public function uploadResetPicture( $validated ,$admin, $picture)
    {
        $result = code(config('admin_code.UploadResetPictureError'));

        $album_id = $validated['id'];

        //如果没有相册id 就把图片存入到默认相册下
        if($album_id == 0 || !isset($album_id))
        {
            $where = [];
            $where[] = ['album','=',0];
            $where[] = ['is_default','=',1];
            $album = Album::where($where)->first();

            if(!$album)
            {
                throw new CommonException('ThisUserHasNoDefaultAlbumError');
            }

            $album_id = $album->id;
        }

        $admin_id = $admin->id;

        if(!$picture->isValid())
        {
            throw new CommonException('UploadSinglePictureAllowError');
        }

        //处理保存路径
        $this->makeSavePath($validated,$admin,$picture);
        //后缀名
        $fileType = $picture->getClientOriginalExtension();
        //文件名带后缀 template.xlsx
        $file_file = $picture->getClientOriginalName();
        //全路径  storage/app/public下
        // config/file/pem/apiclient_key.pem
        // admin/file/4/pem//apiclient_key.pem
        $path =$picture->storeAs($this->filePath,$file_file,'public');
        //保存以后再检测
        $exists = Storage::disk('public')->exists($path);

        if(!$exists)
        {
            throw new CommonException('UploadSinglePictureSaveError');
        }

        $cloudStore = Cache::store('redis')->get('cloud.store');

        if($cloudStore == 'qiniu')
        {
            QiNiuFacade::uploadFile(public_path('storage/'.$path),'storage'.$this->filePath.$file_file);
        }

        $picture_info = getimagesize(storage_path('app/public/').$path);
        $picture_name= \pathinfo($path,\PATHINFO_FILENAME);

        $picture_size = round(filesize(storage_path('app/public/').$path)/1024,0);
        $picture_spec = "{$picture_info[0]}×{$picture_info[1]}";


        $picture_id = $validated['picture_id'];

        //判断是否有图片id 有的话就说明是替换上传 ,没有就是新增

        $oldPicture = AlbumPicture::find($picture_id);

        $revision = $oldPicture->revision;

        $updateWhere = [['id','=',$picture_id],['revision','=',$revision]];

        $updateData = [
            'revision'=>$revision + 1,
            'updated_time'=>time(),
            'updated_at'=> date('Y-m-d H:i:s',time()),
            'picture_file' => $file_file,
            'picture_path' => $this->filePath,
            'picture_size' => $picture_size,
            'picture_spec' => $picture_spec,
            'picture_type' => 10,
        ];

        if($cloudStore == 'qiniu')
        {
            $cdnUrl = trim(Cache::store('redis')->get('qiniu.cdn_url'));

            if(!$cdnUrl)
            {
                throw new CommonException('QiNiuCdnUrlError');
            }

            $updateData['picture_type'] = 20;
            $updateData['picture_url'] = $cdnUrl.'/storage'.$picture_path.$picture_file;
        }

        $updateResult = AlbumPicture::where($updateWhere)->update($updateData);

        if(!$updateResult)
        {
            throw new CommonException('UploadResetPictureSqlError');
        }

        $albumPictrue = AlbumPicture::find($picture_id);

        $this->actionType = isset($validated['type'])?$validated['type']:'';

        //上传文件数据容器
        $uploadFileLogData = [];
        //文件名 template
        $uploadFileLogData['admin_id'] = $admin->id;
        $uploadFileLogData['use_type'] = $validated['use_type'];
        $uploadFileLogData['file_path'] =$this->filePath;
        $uploadFileLogData['file_extension'] = $fileType;
        $uploadFileLogData['file_name'] = pathinfo($path,\PATHINFO_FILENAME);
        $uploadFileLogData['file'] = $file_file;

        CommonEvent::dispatch($admin,['picture_id'=>$picture_id,'data'=>$updateData],'UploadResetPicture');

        /**
         * $path 文件位置
         * $this->$actionType 操作类型 例如 bank配合后端导入数据
         * $fileType 后缀名
         */
        UploadFileEvent::dispatch($admin, $uploadFileLogData,$path, $fileType,$this->actionType);

        $result = code(['code'=>0,'图片替换上传成功!'],['data'=>new AlbumPictureResource($albumPictrue)]);

        return $result;
    }
}
