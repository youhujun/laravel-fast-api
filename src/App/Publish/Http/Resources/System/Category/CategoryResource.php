<?php


namespace App\Http\Resources\System\Category;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Picture\AlbumPictureResource;

class CategoryResource extends JsonResource
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
       if(\is_array($this->resource))
        {
            $response = [
                'id'=>$this->resource['id'],
                'revision'=>$this->resource['revision'],
                'created_at'=>$this->resource['created_at'],
                'updated_at'=>$this->resource['updated_at'],
                'switch'=>$this->resource['switch'],
                'sort'=>$this->resource['sort'],
                'parent_id'=>$this->resource['parent_id'],
                'deep'=>$this->resource['deep'],
                'rate'=>\bcmul($this->resource['rate'],100),
                'category_name'=>$this->resource['category_name'],
                'category_code'=>$this->resource['category_code'],
                'category_picture_id'=>$this->resource['category_picture_id'],
                'remark_info'=>$this->resource['remark_info']
            ];

            if(isset($this->resource['children']) && count($this->resource['children']))
            {
                //p($this->resource['children']);

                $response['children'] = $this->collection($this->resource['children']);
            }

            if(isset($this->resource['picture']) && !is_null($this->resource['picture']))
            {
                $response['picture'] = new AlbumPictureResource($this->resource['picture']);
            }
        }

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->resource->id,
                'revision'=>$this->resource->revision,
                'created_at'=>$this->resource->created_at,
                'updated_at'=>$this->resource->updated_at,
                'switch'=>$this->resource->switch,
                'sort'=>$this->resource->sort,
                'parent_id'=>$this->resource->parent_id,
                'deep'=>$this->resource->deep,
                'rate'=>\bcmul($this->resource->rate,100),
                'category_name'=>$this->resource->category_name,
                'category_code'=>$this->resource->category_code,
                'category_picture_id'=>$this->resource->category_picture_id,
                'remark_info'=>$this->resource->remark_info,
            ];
        }


        /* if($this->resource->relationLoaded('unionResource'))
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

        return $response;
    }


}
