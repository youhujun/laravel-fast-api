<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-11 13:08:48
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-11 13:23:08
 * @FilePath: \api.laravel.com_LV9\app\Http\Resources\User\UserIdCardResource.php
 */

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Picture\AlbumPictureResource;

class UserIdCardResource extends JsonResource
{
    /**
     * 指示是否应保留资源的集合原始键。
     *
     * @var bool
     */
    public $preserveKeys = true;


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

        if(\is_array($this->resource))
        {
             $response = [
                'id'=>$this->resource['id'],
                'is_show'=>$this->resource['is_show'],
                'type'=>$this->resource['type'],
                'config_name'=>$this->resource['config_name'],
            ];

            if(isset($this->resource['children']) && count($this->resource['children']))
            {
                //p($this->resource['children']);
                $response['children'] = $this->collection($this->resource['children']);
            }
        }

        if(\is_object($this->resource))
        {
            $response = [
                'id' => $this->resource->id,
                'user_id' => $this->resource->user_id,
                'id_card_front_id' => $this->resource->id_card_front_id,
                'id_card_back_id' => $this->resource->id_card_back_id,
                'created_at' => $this->resource->created_at,
                'updated_at' => $this->resource->updated_at,
                'sort' => $this->resource->sort,
            ];

            //p($this->resource);die;

           if($this->resource->relationLoaded('cardFront'))
            {
                if(!is_null($this->resource->cardFront))
                {
                    $response['card_front'] = new AlbumPictureResource($this->resource->cardFront);
                }
            }

            if($this->resource->relationLoaded('cardBack'))
            {
                if(!is_null($this->resource->cardBack))
                {
                    $response['card_back'] = new AlbumPictureResource($this->resource->cardBack);
                }
            }

          /*   if($this->resource->relationLoaded('unionCollection'))
            {
                if(!is_null($this->collection))
                {
                    $response['union_collection'] = ReplaceUnionResource::collection($this->collection);
                }
            } */
        }

        return $response;
    }


}
