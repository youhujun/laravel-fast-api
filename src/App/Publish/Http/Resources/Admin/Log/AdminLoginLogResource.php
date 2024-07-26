<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 16:43:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 17:18:04
 * @FilePath: \app\Http\Resources\Admin\Log\AdminLoginLogResource.php
 */

namespace App\Http\Resources\Admin\Log;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminLoginLogResource extends JsonResource
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

       /*  if(\is_array($this->resource))
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
        } */

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->id,
                'created_at'=>$this->created_at,
                'admin_id'=>$this->admin_id,
                'instruction'=>$this->instruction,
                'status'=>$this->status,
                'ip'=>$this->ip,
                'source'=>$this->source
            ];

            if($this->resource->relationLoaded('admin'))
            {
                $response['user_id'] = $this->admin->user_id;
                $user = $this->admin->user;
                $user_info = $this->admin->user->userInfo;
                $response['phone'] = $user->phone;
                $response['account_name'] = $user->account_name;
                $response['nick_name'] = $user_info->nick_name;
            }

           /*  if($this->resource->relationLoaded('unionResource'))
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
