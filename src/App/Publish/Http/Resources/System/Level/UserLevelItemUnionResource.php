<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-17 19:02:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-30 16:11:30
 */

namespace App\Http\Resources\System\Level;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLevelItemUnionResource extends JsonResource
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
            'sort'=>$this->sort,
            'user_level_id'=>$this->user_level_id,
            'level_item_id'=>$this->level_item_id,
            'value'=>$this->value,
            'value_type'=>$this->value_type
        ];


        return $response;
    }


}
