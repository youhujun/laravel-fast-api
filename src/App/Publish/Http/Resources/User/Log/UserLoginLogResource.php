<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 19:02:07
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-10 10:33:32
 * @FilePath: \app\Http\Resources\User\Log\UserLoginLogResource.php
 */

namespace App\Http\Resources\User\Log;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginLogResource extends JsonResource
{
    /**
     * 指示是否应保留资源的集合原始键。
     *
     * @var bool
     */
    public $preserveKeys = true;

    protected static $sourceName = [0=>'无',10=>'H5',20=>'MiniProgram',30=>'App',40=>'PC'];

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

       /*  if(\is_array($this->resource))
        {
             $response = [
                'id'=>$this->resource['id'],
                'is_show'=>$this->resource['is_show'],
                'type'=>$this->resource['type'],
                'config_name'=>$this->resource['config_name'],
            ];

            if(isset($this->resource['children']) && count($this->resource['children']))
            {
                //p($this->resource['children']);
                $response['children'] = $this->collection($this->resource['children']);
            }
        } */

        if(\is_object($this->resource))
        {
            $response = [
                'id'=>$this->id,
                'created_at'=>$this->created_at,
                'user_id'=>$this->user_id,
                'instruction'=>$this->instruction,
                'status'=>$this->status,
                'ip'=>$this->ip,
                'source_type'=>$this->source_type,
                'source_name'=>self::$sourceName[$this->source_type]
            ];

            if($this->resource->relationLoaded('user'))
            {
                $user = null;

                $user = $this->user;

                if($user)
                {
                    $response['phone'] = null;
                    $response['account_name'] = null;
                    $response['nick_name'] = null;



                    if(isset($user->phone))
                    {
                        $response['phone'] = $user->phone;
                    }

                    if(isset($user->account_name))
                    {
                        $response['account_name'] = $user->account_name;
                    }

                    if(isset($user->userInfo))
                    {
                        $user_info = $user->userInfo;
                        $response['nick_name'] = $user_info->nick_name;
                    }
                }
            }

           /*  if($this->resource->relationLoaded('unionResource'))
            {
                if(!is_null($this->rescource))
                {
                    $response['union_rescource'] = new ReplaceUnionResource($this->rescource);
                }
            }

            if($this->resource->relationLoaded('unionCollection'))
            {
                if(!is_null($this->collection))
                {
                    $response['union_collection'] = ReplaceUnionResource::collection($this->collection);
                }
            } */
        }

        return $response;
    }


}
