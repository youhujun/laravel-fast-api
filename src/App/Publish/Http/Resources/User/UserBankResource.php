<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-07 17:51:38
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 16:41:38
 */

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\BankResource;
use App\Http\Resources\System\Picture\AlbumPictureResource;

class UserBankResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'is_default'=>$this->is_default,
            'sort'=>$this->sort,
            'bank_id'=>$this->bank_id,
            'bank_number'=>$this->bank_number,
            'bank_account'=>$this->bank_account,
            'bank_address'=>$this->bank_address,
            'bank_front_id'=>$this->bank_front_id,
            'bank_back_id'=>$this->bank_back_id
        ];

        if($this->resource->relationLoaded('bank'))
        {
            if(!is_null($this->bank))
            {
                $response['bank'] = new BankResource($this->bank);
                $response['bank_name'] = $this->bank->bank_name;
            }
        }

        if($this->resource->relationLoaded('bankFront'))
        {
            if(!is_null($this->bankFront))
            {
                $response['bank_front'] = new AlbumPictureResource($this->bankFront);
                $response['bank_front_pciture'] = asset('storage'.$this->bankFront->picture_path.DIRECTORY_SEPARATOR.$this->bankFront->picture_file);
            }
        }

        if($this->resource->relationLoaded('bankBack'))
        {
            if(!is_null($this->bankBack))
            {
                $response['bank_back'] = new AlbumPictureResource($this->bankBack);
                $response['bank_back_pciture'] = asset('storage'.$this->bankBack->picture_path.DIRECTORY_SEPARATOR.$this->bankBack->picture_file);
            }
        }

        return $response;
    }


}
