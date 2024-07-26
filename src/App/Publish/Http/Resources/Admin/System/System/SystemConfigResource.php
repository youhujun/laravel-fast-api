<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-14 21:12:07
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-14 21:44:03
 * @FilePath: \app\Http\Resources\Admin\System\System\SystemConfigResource.php
 */


namespace App\Http\Resources\Admin\System\System;

use Illuminate\Http\Resources\Json\JsonResource;

class SystemConfigResource extends JsonResource
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
             $value = [10=>$this->resource['item_value'],20=>$this->resource['item_value'],30=>$this->resource['item_price'],40=>$this->resource['item_path']];

             $response = [
                'id'=>$this->resource['id'],
                'item_type'=>$this->resource['item_type'],
                'item_label'=>$this->resource['item_label'],
                'item_value'=>$value[$this->resource['item_type']],
                'item_introduction'=>$this->resource['item_introduction'],
                'created_at'=>$this->resource['created_at'],
                'updated_at'=>$this->resource['updated_at'],
                'sort'=>$this->resource['sort'],
            ];
        }

        if(\is_object($this->resource))
        {
            $value = [10=>$this->resource->item_value,20=>$this->resource->item_value,30=>$this->resource->item_price,40=>$this->resource->item_path];

            $response = [
                'id'=>$this->resource->id,
                'item_type'=>$this->resource->item_type,
                'item_label'=>$this->resource->item_label,
                'item_value'=>$value[$this->resource->item_type],
                'item_introduction'=>$this->resource->item_introduction,
                'created_at'=>$this->resource->created_at,
                'updated_at'=>$this->resource->updated_at,
                'sort'=>$this->resource->sort,
            ];
        }

        return $response;
    }


}
