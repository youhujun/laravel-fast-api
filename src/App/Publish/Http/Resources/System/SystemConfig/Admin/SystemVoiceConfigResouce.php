<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-19 13:01:10
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-26 16:49:03
 * @FilePath: d:\wwwroot\Working\YouHu\Componenets\Laravel\youhujun\laravel-fast-api\src\App\Publish\Http\Resources\System\SystemConfig\Admin\SystemVoiceConfigResouce.php
 */

namespace App\Http\Resources\System\SystemConfig\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SystemVoiceConfigResouce extends JsonResource
{
    /**
     * 指示是否应保留资源的集合原始键。
     *
     * @var bool
     */
    public $preserveKeys = true;

    public static $replaceType;

    public static function setReplaceType($replaceType = 10)
    {
        self::$replaceType = $replaceType;
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

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->resource->id,
                'voice_title'=>$this->resource->voice_title,
                'channle_name'=>$this->resource->channle_name,
                'channle_event'=>$this->resource->channle_event,
                'note'=>$this->resource->note,
                'created_at'=>$this->resource->created_at,
				'sort'=>$this->resource->sort,
            ];

            $app_url = config('app.url');
            //本地存储
            if($this->resource->voice_save_type == 10)
            {
                 $response['voice_url'] = $app_url.DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.$this->resource->voice_path;
            }

            //存储桶存储
            if($this->resource->voice_save_type == 20)
            {
                $response['voice_url'] = $this->resource->voice_url;
            }

        }

        return $response;
    }


}
