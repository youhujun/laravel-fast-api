<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-19 13:01:18
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 13:02:39
 * @FilePath: \app\Http\Resources\System\SystemConfig\Admin\SystemVoiceConfigCollection.php
 */

namespace App\Http\Resources\System\SystemConfig\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\System\SystemConfig\Admin\SystemVoiceConfigResouce;

class SystemVoiceConfigCollection extends ResourceCollection
{
    /**
     * 指示是否应保留资源的集合原始键。
     *
     * @var bool
     */
     public $preserveKeys = true;

     /**
     * The resource that this resource collects.
     * 自定义资源类名
     *
     * @var string
     */
     public $collects = SystemVoiceConfigResouce::class;

     /**
      * 返回码
      *
      * @var [array]
      */
     public $codeArray;

     /**
      * 下载地址
      *
      * @var [string]
      */
     public $download;


     /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource,$codeArray,$download = null)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);

        $this->codeArray = $codeArray;

        $this->download = $download;
    }


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $response = ['data'=>$this->collection];

        return $response;
    }


    /**
     * 返回应该和资源一起返回的其他数据数组。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        $data = $this->codeArray;

        if(!is_null($this->download))
        {
            $data['download']= $this->download;
        }

        return  $data;
    }
}
