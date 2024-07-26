<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-04 00:55:27
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-05 00:23:35
 * @FilePath: \app\Http\Resources\Admin\AdminResource.php
 */

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Role\RoleResource;

class AdminResource extends JsonResource
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
                'id'=>$this->resource->id,
                'user_id'=>$this->resource->user_id,
                'switch'=>$this->resource->switch,
                'account_name'=>$this->resource->account_name,
                'phone'=>$this->resource->email,
                'created_at'=>$this->resource->created_at,
            ];

            if($this->resource->relationLoaded('user'))
            {
                $user = $this->resource->user;

                if($user->relationLoaded('userInfo'))
                {
                    $userInfo = $user->userInfo;

                    $response['nick_name'] = $userInfo->nick_name;
                    $response['real_name'] = $userInfo->real_name;
                    $response['solar_birthday_at'] = $userInfo->solar_birthday_at;
                    $response['chinese_birthday_at'] = $userInfo->chinese_birthday_at;
                    $response['sex'] = $userInfo->sex;
                    $response['id_number'] = $userInfo->id_number;
                    $response['introduction'] = $userInfo->introduction;
                }

                if($user->relationLoaded('userAvatar'))
                {
                    $userAvatar = $user->userAvatar->firstWhere('is_default',1);

                    if($userAvatar->relationLoaded('albumPicture'))
                    {
                        $albumPicture = $userAvatar->albumPicture;
                        $response['avatar'] = asset('storage'.$albumPicture->picture_path.DIRECTORY_SEPARATOR.$albumPicture->picture_file);
                    }

                }

                if($user->relationLoaded('role'))
                {
                    $role = $user->role;
                    $response['role'] = RoleResource::collection($role);
                }

            }

        }

        return $response;
    }


}
