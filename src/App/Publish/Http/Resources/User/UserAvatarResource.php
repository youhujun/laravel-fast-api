<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Picture\AlbumPictureResource;

class UserAvatarResource extends JsonResource
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

        //p($this->resource);die;
        // return parent::toArray($request);
        $response = [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'album_picture_id'=>$this->user_id,
            'created_at'=>$this->created_at,
            'is_default'=>$this->switch
        ];

        if($this->resource->relationLoaded('albumPicture'))
        {
            if(!is_null($this->albumPicture))
            {
                $response['album_picture'] = new AlbumPictureResource($this->albumPicture);
            }
        }

        return $response;
    }


}
