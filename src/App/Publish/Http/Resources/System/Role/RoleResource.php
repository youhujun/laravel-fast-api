<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-05 15:19:19
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 19:58:01
 * @FilePath: \app\Http\Resources\System\Role\RoleResource.php
 */

namespace App\Http\Resources\System\Role;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Permission\PermissionResource;
use App\Models\System\Role\Role;

class RoleResource extends JsonResource
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

        if(\is_array($this->resource))
        {
             $response = [
                'id'=>$this->resource['id'],
                'parent_id'=>$this->resource['parent_id'],
                'deep'=>$this->resource['deep'],
                'switch'=>$this->resource['switch'],
                'role_name'=>$this->resource['role_name'],
                'logic_name'=>$this->resource['logic_name'],
                /* 'created_at'=>$this->resource['created_at'],
                'updated_at'=>$this->resource['updated_at'], */
                'sort'=>$this->resource['sort'],
            ];

            if(isset($this->resource['children']) && count($this->resource['children']))
            {
                //p($this->resource['children']);
                $response['children'] = $this->collection($this->resource['children']);
            }

           if(isset($this->resource['permission']) && count($this->resource['permission']))
            {
                //p($this->resource['permission']);
                $response['permission'] = $this->resource['permission'];
            }
        }

        if(\is_object($this->resource))
        {

            $response = [
                'id'=>$this->resource->id,
                'parent_id'=>$this->resource->parent_id,
                'deep'=>$this->resource->deep,
                'switch'=>$this->resource->switch,
                'role_name'=>$this->resource->role_name,
                'logic_name'=>$this->resource->logic_name,
               /*  'created_at'=>$this->resource->created_at,
                'updated_at'=>$this->resource->updated_at, */
                'sort'=>$this->resource->sort,
            ];

            if(isset($this->resource->children) && count($this->resource->children))
            {
                //p($this->resource['children']);
                $response['children'] = $this->collection($this->resource->children);
            }

            if($this->resource instanceof Role)
            {
                if($this->resource->relationLoaded('permission'))
                {
                    if(isset($this->resource->permission) && count($this->resource->permission))
                    {
                        //p($this->resource['permission']);
                        $response['permission'] = $this->resource->permission;
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
