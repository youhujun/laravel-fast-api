<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-30 09:28:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 16:31:49
 * @FilePath: \app\Http\Resources\Help\LabelRecource.php
 */

namespace App\Http\Resources\Help;

use Illuminate\Http\Resources\Json\JsonResource;

class LabelRecource extends JsonResource
{
    /**
     * 指示是否应保留资源的集合原始键。
     *
     * @var bool
     */
    public $preserveKeys = true;

    /**
     * 使用类型
     *
     * @var integer 10 文章关联使用
     */
    protected static $useType = 0;

    public static function setUseType($useType = 0)
    {
        self::$useType = $useType;
    }


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
                'created_at'=>$this->resource['created_at'],
                'switch'=>$this->resource['switch'],
                'sort'=>$this->resource['sort'],
                'parent_id'=>$this->resource['parent_id'],
                'deep'=>$this->resource['deep'],
                'label_name'=>$this->resource['label_name'],
                'label_code'=>$this->resource['label_code'],
                'remark_info'=>$this->resource['remark_info']
            ];

            if(isset($this->resource['children']) && count($this->resource['children']))
            {
                //p($this->resource['children']);

                $response['children'] = $this->collection($this->resource['children']);
            }

            if(isset($this->resource['picture']) && !is_null($this->resource['picture']))
            {
                $response['picture'] = asset('storage'.$this->resource['picture']['picture_path'].DIRECTORY_SEPARATOR.$this->resource['picture']['picture_file']);
            }
        }

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->resource->id,
               // 'revision'=>$this->resource->revision,
                //'created_at'=>$this->resource->created_at,
                //'updated_at'=>$this->resource->updated_at,
                //'switch'=>$this->resource->switch,
                'sort'=>$this->resource->sort,
                'parent_id'=>$this->resource->parent_id,
                'deep'=>$this->resource->deep,
                'label_name'=>$this->resource->label_name,
               // 'label_code'=>$this->resource->label_code,
               // 'label_picture_id'=>$this->resource->label_picture_id,
                'remark_info'=>$this->resource->remark_info,
            ];

            if(self::$useType == 10)
            {
                $response = [
                    'label_id'=>$this->resource->id,
                    'label_name'=>$this->resource->label_name,
                    'label_code'=>$this->resource->label_code,
                ];
            }
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
