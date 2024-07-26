<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-11 20:10:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 20:18:19
 * @FilePath: \app\Http\Resources\User\UserAccountLogResource.php
 */

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAccountLogResource extends JsonResource
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
                'id' => $this->resource->id ,
                'user_id' => $this->resource->user_id ,
                'type' => $this->resource->type ,
                'remark_info' => $this->resource->remark_info ,
                'created_at' => $this->resource->created_at ,
                'updated_at' => $this->resource->updated_at ,
                'sort' => $this->resource->sort ,
            ];

            if(isset($this->resource->amount))
            {
                 $response['amount'] = number_format($this->resource->amount,2,'.') ;
            }

            if(isset($this->resource->balance))
            {
                 $response['balance'] = number_format($this->resource->balance,2,'.');
            }

            if(isset($this->resource->coin))
            {
                 $response['coin'] = number_format($this->resource->coin,2,'.');
            }

            if(isset($this->resource->score))
            {
                 $response['score'] = number_format($this->resource->score,2,'.');
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
