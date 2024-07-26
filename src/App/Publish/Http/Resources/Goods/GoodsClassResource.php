<?php

namespace App\Http\Resources\Goods;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsClassResource extends JsonResource
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
                'deep'=>$this->resource['deep'],
                'switch'=>$this->resource['switch'],
                'rate'=> bcmul($this->resource['rate'],100,0) ,
                'goods_class_name'=>$this->resource['goods_class_name'],
                'goods_class_code'=>$this->resource['goods_class_code'],
                'is_certificate'=>$this->resource['is_certificate'],
                'certificate_number'=>$this->resource['certificate_number'],
                'remark_info'=>$this->resource['remark_info'],
                'created_at'=>$this->resource['created_at'],
                'sort'=>$this->resource['sort'],
            ];

            if(isset($this->resource['children']) && count($this->resource['children']))
            {
                //p($this->resource['children']);
                $response['children'] = $this->collection($this->resource['children']);
            }

            if(isset($this->resource['picture']))
            {

                //p($this->resource['picture']);
                $response['picture'] = asset('storage'.$this->resource['picture']['picture_path'].DIRECTORY_SEPARATOR.$this->resource['picture']['picture_file']);
            }
        }

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->resource->id,
                'parent_id'=>$this->resource->parent_id,
                'deep'=>$this->resource->deep,
                'switch'=>$this->resource->switch,
                'rate'=>$this->resource->rate,
                'goods_class_name'=>$this->resource->goods_class_name,
                'goods_class_code'=>$this->resource->goods_class_code,
                'is_certificate'=>$this->resource->is_certificate,
                'certificate_number'=>$this->resource->certificate_number,
                'remark_info'=>$this->resource->remark_info,
                'created_at'=>$this->resource->created_at
            ];

          /*   if($this->resource->relationLoaded('unionResource'))
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
