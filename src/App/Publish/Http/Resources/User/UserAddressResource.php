<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-07 12:00:13
 * @LastEditors: YouHuJun
 * @LastEditTime: 2023-04-10 10:42:09
 */

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\RegionResource;

class UserAddressResource extends JsonResource
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
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'is_default'=>$this->is_default,
            'country_id'=>$this->country_id,
            'province_id'=>$this->province_id,
            'region_id'=>$this->region_id,
            'city_id'=>$this->city_id,
            'address_info'=>$this->address_info,
            'address_type'=>$this->address_type
        ];

        if($this->resource->relationLoaded('country'))
        {
            if(!is_null($this->country))
            {
                $response['country'] = new RegionResource($this->country);
                $response['country_name'] = $this->country->region_name;
            }
        }


        if($this->resource->relationLoaded('province'))
        {
            if(!is_null($this->province))
            {
                $response['province'] = new RegionResource($this->province);
                $response['province_name'] = $this->province->region_name;
            }
        }

        if($this->resource->relationLoaded('region'))
        {
            if(!is_null($this->region))
            {
                $response['region'] = new RegionResource($this->region);
                $response['region_name'] = $this->region->region_name;
            }
        }

        if($this->resource->relationLoaded('city'))
        {
            if(!is_null($this->region))
            {
                $response['city'] = new RegionResource($this->city);
                $response['city_name'] = $this->city->region_name;
            }
        }
        return $response;
    }


}
