<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-05 17:22:56
 * @LastEditors: YouHuJun
 * @LastEditTime: 2023-04-07 14:47:40
 */

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\User\UserResource;

class UserCollection extends ResourceCollection
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
     public $collects = UserResource::class;

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
      * 待审核人数
      *
      * @var [integer]
      */
     public $number;

     /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource,$codeArray,$download = null,$number = null)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);

        $this->codeArray = $codeArray;

        $this->download = $download;

        $this->number = $number;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

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

        if(!is_null($this->number))
        {
            $data['applyNumber']= $this->number;
        }

        // $data['applyNumber']= $this->number;

        return  $data;
    }
}
