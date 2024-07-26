<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-27 21:10:38
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-27 21:15:19
 * @FilePath: \app\Http\Resources\User\Level\UserLevelResource.php
 */

namespace App\Http\Resources\User\Level;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Level\LevelItemResource;
use App\Http\Resources\System\Level\LevelItemCollection;

use App\Http\Resources\System\Picture\AlbumPictureResource;

class UserLevelResource extends JsonResource
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

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->id,
                'sort'=>$this->sort,
                'created_at'=>$this->created_at,
                'switch'=>$this->switch,
                'level_name'=>$this->level_name,
                'level_code'=>$this->level_code,
                'amount'=>$this->amount,
                'background_id'=>$this->background_id,
                'bak_info'=>$this->bak_info
            ];

            if($this->resource->relationLoaded('levelItem'))
            {
                if(!is_null($this->levelItem))
                {
                    $response['level_item'] = LevelItemResource::collection($this->levelItem);
                }
            }

            if($this->resource->relationLoaded('background'))
            {
                if(!is_null($this->background))
                {
                    $response['background'] = new AlbumPictureResource($this->background);
                }
            }

        }

        return $response;
    }


}
