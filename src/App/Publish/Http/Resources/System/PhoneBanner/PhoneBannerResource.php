<?php

namespace App\Http\Resources\System\PhoneBanner;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Picture\AlbumPictureResource;

class PhoneBannerResource extends JsonResource
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

         $response = [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'album_picture_id'=>$this->album_picture_id,
            'redirect_url'=>$this->redirect_url,
            'bak_info'=>$this->bak_info,
            'sort'=>$this->sort,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];

        if($this->resource->relationLoaded('picture'))
        {
            if(!is_null($this->picture))
            {
                //$response['picture'] = new AlbumPictureResource($this->picture);
                $response['picture'] = asset('storage'.$this->picture->picture_path.DIRECTORY_SEPARATOR.$this->picture->picture_file);
            }
        }

        /* if($this->resource->relationLoaded('unionCollection'))
        {
            if(!is_null($this->collection))
            {
                $response['union_collection'] = ReplaceUnionResource::collection($this->collection);
            }
        } */


        return $response;

    }

}
