<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-01-10 20:16:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-01-10 20:18:48
 * @FilePath: \api.laravel.com_LV9\app\Http\Resources\Help\Region\VoteResource.php
 */

namespace App\Http\Resources\Help\Region;

use Illuminate\Http\Resources\Json\JsonResource;

class VoteResource extends JsonResource
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
                'parent_id'=>$this->resource['parent_id'],
                'label_name'=>$this->resource['label_name'],
                'deep'=>$this->resource['deep'],
                'sort'=>$this->resource['sort'],
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
                'id'=>$this->resource->id,
                'parent_id'=>$this->resource->parent_id,
                'label_name'=>$this->resource->label_name,
                'deep'=>$this->resource->deep,
                'sort'=>$this->resource->sort,
            ];

          if($this->resource->relationLoaded('unionResource'))
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
            }
        }

        return $response;
    }


}
