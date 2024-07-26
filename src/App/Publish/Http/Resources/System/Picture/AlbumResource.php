<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-04-07 11:14:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 13:44:46
 * @FilePath: \app\Http\Resources\System\Picture\AlbumResource.php
 */

namespace App\Http\Resources\System\Picture;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Picture\AlbumPictureResource;

class AlbumResource extends JsonResource
{
    /**
     * 指示是否应保留资源的集合原始键。
     *
     * @var bool
     */
    public $preserveKeys = true;

    /**
     * 响应数据时是否包含图片
     *
     * @var [type]
     */
    public static $with_picture;


    /**
     * 设置 响应数据时是否包含图片
     *
     * @param integer $with_picture
     * @return void
     */
    public static function setWithPicture($with_picture = 0)
    {
            self::$with_picture = $with_picture;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $response =  [
                'id' => $this->id,
				'user_id' => $this->user_id,
				'cover_album_picture_id' => $this->cover_album_picture_id,
				'revision' => $this->revision,
				'is_default' => $this->is_default,
                'is_system'=> $this->is_system,
				'album_name' => $this->album_name,
				'album_description' => $this->album_description,
				'album_type' => $this->album_type,
				'created_at' => $this->created_at,
				/* 'updated_at' => $this->updated_at, */
				'sort' => $this->sort,
                'picture_number'=> $this->albumPicture->count(),
        ];

        if($this->resource->relationLoaded('coverAlbumPicture'))
        {
            if(!is_null($this->coverAlbumPicture))
            {
                //$response['cover_album_picture'] = new AlbumPictureResource($this->coverAlbumPicture);
                $response['cover_album_picture'] = asset('storage'.$this->coverAlbumPicture->picture_path.DIRECTORY_SEPARATOR.$this->coverAlbumPicture->picture_file);
            }
        }

        if($this->resource->has_picture || self::$with_picture)
        {

            if($this->resource->relationLoaded('albumPicture'))
            {
                if(!is_null($this->albumPicture))
                {
                    $response['album_picture'] = AlbumPictureResource::collection($this->albumPicture);
                }
            }
        }

        return $response;
    }


}
