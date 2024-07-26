<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 11:45:49
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 15:53:17
 * @FilePath: \app\Http\Resources\Article\ArticleCollection.php
 */

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\Article\ArticleResource;

class ArticleCollection extends ResourceCollection
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
     public $collects = ArticleResource::class;

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
