<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-05 14:53:28
 * @LastEditors: YouHuJun
 * @LastEditTime: 2023-04-10 10:09:51
 */


namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
        //return parent::toArray($request);

        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'nick_name'=>$this->nick_name,
            'family_name'=>$this->family_name,
            'name'=>$this->name,
            'real_name'=>$this->real_name,
            'id_number'=>$this->id_number,
            'sex'=>$this->sex,
            'solar_birthday_at'=>$this->solar_birthday_at,
            'chinese_birthday_at'=>$this->chinese_birthday_at,
            'introduction'=>$this->introduction
        ];
    }
}
