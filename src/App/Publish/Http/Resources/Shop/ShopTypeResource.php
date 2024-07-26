<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-01 10:05:02
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-01 10:14:39
 * @FilePath: \api.laravel.com_LV9\app\Http\Resources\Shop\ShopTypeResource.php
 */

namespace App\Http\Resources\Shop;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopTypeResource extends JsonResource
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
        $response = [];

        if(\is_array($this->resource))
        {
             $response = [
                'id'=>$this->resource['id'],
                'is_show'=>$this->resource['is_show'],
                'type'=>$this->resource['type'],
                'config_name'=>$this->resource['config_name'],
            ];
        }

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->resource->id,
				'created_at'=>$this->resource->created_at,
				'updated_at'=>$this->resource->updated_at,
				'sort'=>$this->resource->sort,
				'is_default'=>$this->resource->is_default,
				'shop_type_number'=>$this->resource->shop_type_number,
				'shop_type_name'=>$this->resource->shop_type_name,
				'shop_type_code'=>$this->resource->shop_type_code
            ];

          /*   if($this->resource->relationLoaded('unionResource'))
            {
                if(!is_null($this->rescource))
                {
                    $response['union_rescource'] = new ReplaceUnionResource($this->rescource);
                }
            }

            if($this->resource->relationLoaded('unionCollection'))
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
