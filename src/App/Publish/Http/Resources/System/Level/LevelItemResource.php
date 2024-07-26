<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-13 17:13:06
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 22:53:53
 */

namespace App\Http\Resources\System\Level;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Level\UserLevelItemUnionResource;
use App\Http\Resources\System\Level\TechnicianlevelItemUnionResource;
use App\Http\Resources\System\Level\ShopLevelItemUnionResource;

class LevelItemResource extends JsonResource
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

        $response = [
            'id'=>$this->id,
            'created_at'=>$this->created_at,
           /*  'updated_at'=>$this->updated_at, */
            'sort'=>$this->sort,
            'type'=>$this->type,
            'item_name'=>$this->item_name,
            'item_code'=>$this->item_code,
            'description'=>$this->description,
        ];


        if($this->resource->relationLoaded('userLevelItemValue'))
        {
            if(!is_null($this->userLevelItemValue))
            {
                $response['user_level_item_value'] = new UserLevelItemUnionResource($this->userLevelItemValue);
            }
        }

        if($this->resource->relationLoaded('shopLevelItemValue'))
        {
            if(!is_null($this->shopLevelItemValue))
            {
                $response['shop_level_item_value'] = new ShopLevelItemUnionResource($this->shopLevelItemValue);
            }
        }

        return $response;
    }


}
