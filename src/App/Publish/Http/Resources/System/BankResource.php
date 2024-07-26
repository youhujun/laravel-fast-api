<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-07 17:57:28
 * @LastEditors: YouHuJun
 * @LastEditTime: 2023-04-10 10:49:48
 */

namespace App\Http\Resources\System;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\User\UserBankResource;

class BankResource extends JsonResource
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
            'bank_name'=>$this->bank_name,
            'bank_code'=>$this->bank_code,
            'is_default'=>$this->is_default,
            'sort'=>$this->sort
        ];

        if($this->resource->relationLoaded('userBank'))
        {
            if(!is_null($this->userBank))
            {
                $response['user_bank'] = UserBankResource::collection($this->userBank);
            }
        }

        return $response;
    }


}
