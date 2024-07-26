<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-04-07 12:00:42
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-11 10:39:43
 * @FilePath: \api.laravel.com_LV9\app\Http\Resources\User\UserApplyRealAuthResource.php
 */


namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserApplyRealAuthResource extends JsonResource
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
            'user_id'=>$this->user_id,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'sort'=>$this->sort,
            'status'=>$this->status,
            'auth_apply_at'=>$this->auth_apply_at,
            'auth_at'=>$this->auth_at,
            'refuse_info'=>$this->refuse_info
        ];
    }


}
