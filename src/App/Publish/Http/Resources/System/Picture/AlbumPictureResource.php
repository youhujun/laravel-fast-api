<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-04-07 11:15:07
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 12:46:25
 * @FilePath: \app\Http\Resources\System\Picture\AlbumPictureResource.php
 */

namespace App\Http\Resources\System\Picture;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumPictureResource extends JsonResource
{
    /**
     * 指示是否应保留资源的集合原始键。
     *
     * @var bool
     */
    public $preserveKeys = true;

    /**
     * 只显示图片路径
     *
     * @var boolean
     */
    public static $onlyShowPicture = false;

    public static function onlyShowPictureUrl()
    {
        self::$onlyShowPicture = true;
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

        $response = [];

        if(is_array($this->resource))
        {
                if(self::$onlyShowPicture)
                {
                    $response = [
                        'picture'=>asset('storage'.$this->resource['picture_path'].DIRECTORY_SEPARATOR.$this->resource['picture_file'])
                    ];
                }
                else
                {
                     $response = [
                        'id'=>$this->resource['id'],
                        'user_id'=>$this->resource['user_id'],
                        'album_id'=>$this->resource['album_id'],
                        'created_at'=>$this->resource['created_at'],
                        'updated_at'=>$this->resource['updated_at'],
                        'picture_name'=>$this->resource['picture_name'],
                        'picture_path'=>$this->resource['picture_path'],
                        'picture_file'=>$this->resource['picture_file'],
                        'picture_size'=>$this->resource['picture_size'],
                        'picture_spec'=>$this->resource['picture_spec'],
                        'picture'=>asset('storage'.$this->resource['picture_path'].DIRECTORY_SEPARATOR.$this->resource['picture_file'])
                    ];
                }


            if(isset($this->resource['goods_picture_union_id']))
            {
                $response['goods_picture_union_id'] = $this->resource['goods_picture_union_id'];
            }
        }

        if(\is_object($this->resource))
        {
            if(self::$onlyShowPicture)
            {
                $response = [
                    'picture'=>asset('storage'.$this->picture_path.DIRECTORY_SEPARATOR.$this->picture_file)
                ];
            }
            else
            {
                $response = [
                    'id'=>$this->id,
                    'user_id'=>$this->user_id,
                    'album_id'=>$this->album_id,
                    'created_at'=>$this->created_at,
                    'updated_at'=>$this->updated_at,
                    'picture_name'=>$this->picture_name,
                    'picture_path'=>$this->picture_path,
                    'picture_file'=>$this->picture_file,
                    'picture_size'=>$this->picture_size,
                    'picture_spec'=>$this->picture_spec,
                    'picture'=>asset('storage'.$this->picture_path.DIRECTORY_SEPARATOR.$this->picture_file)
                ];
            }


            if(isset($this->resource->goods_picture_union_id))
            {
                $response['goods_picture_union_id'] = $this->resource->goods_picture_union_id;
            }
        }

        return $response;
    }

}
