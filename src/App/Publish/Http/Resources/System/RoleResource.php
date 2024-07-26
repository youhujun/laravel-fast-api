<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-07 11:54:59
 * @LastEditors: YouHuJun
 * @LastEditTime: 2023-04-07 11:58:26
 */

namespace App\Http\Resources\System;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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

        return [
            'id'=>$this->id,
            'parent_id'=>$this->parent_id,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'role_name'=>$this->role_name,
            'logic_name'=>$this->logic_name,
            'deep'=>$this->deep,
            'sort'=>$this->sort,
            'switch'=>$this->switch

        ];
    }


}
