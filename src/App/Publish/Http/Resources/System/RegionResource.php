<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-04-07 12:03:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 00:54:33
 * @FilePath: \app\Http\Resources\System\RegionResource.php
 */


namespace App\Http\Resources\System;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * 指示是否应保留资源的集合原始键。
     *
     * @var bool
     */
    public $preserveKeys = true;

    /**
     * 控制是否显示详情
     *
     * @var [type]
     */
    public static $showInfo ;

    public static function showControl($showInfo = 0)
    {
        self::$showInfo = $showInfo;
    }


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

        if(is_array($this->resource))
        {
            $response = [
                'id'=>$this->resource['id'],
                'region_name'=>$this->resource['region_name']
            ];

            if(self::$showInfo)
            {
                 $response['parent_id'] = $this->resource['parent_id'];
                 $response['deep'] = $this->resource['deep'];
                 $response['region_area'] = $this->resource['region_area'];
                 $response['created_at'] = $this->resource['created_at'];
                /*  $response['updated_at'] = $this->resource['updated_at']; */
                 $response['sort'] = $this->resource['sort'];
            }

            if(isset($this->resource['children']) && count($this->resource['children']))
            {
                //p($this->resource['children']);
                $response['children'] = $this->collection($this->resource['children']);
            }


        }

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->id,
                'parent_id '=>$this->parent_id,
                'deep'=>$this->deep,
                'region_name'=>$this->region_name,
                'region_area'=>$this->region_area,
                'created_at'=>$this->created_at,
                'sort'=>$this->sort
            ];
        }

        return $response;
    }


}
