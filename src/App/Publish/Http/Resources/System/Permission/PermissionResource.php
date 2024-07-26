<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-05 15:10:19
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 22:35:30
 * @FilePath: \app\Http\Resources\System\Permission\PermissionResource.php
 */

namespace App\Http\Resources\System\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\System\Role\RoleResource;

class PermissionResource extends JsonResource
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
            //p($this->resource);die;
             $response = [
                'id'=>$this->resource['id'],
                'parent_id'=>$this->resource['parent_id'],
                'deep'=>$this->resource['deep'],
                'is_menu'=>$this->resource['is_menu'],
                'path'=>$this->resource['path'],
                'component'=>$this->resource['component'],
                'name'=>$this->resource['name'],
                'hidden'=>$this->resource['hidden'],
                'alwaysShow'=>$this->resource['alwaysShow'],
                'redirect'=>$this->resource['redirect'] ,
                'meta_title'=>$this->resource['meta_title'],
                'meta_roles'=>$this->resource['meta_roles'],
                'meta_icon'=>$this->resource['meta_icon'],
                'meta_noCache'=>$this->resource['meta_noCache'],
                'meta_affix'=>$this->resource['meta_affix'],
                'meta_breadcrumb'=>$this->resource['meta_breadcrumb'],
                'meta_activeMenu'=>$this->resource['meta_activeMenu'],
                'switch'=>$this->resource['switch'],
               /*  'created_at'=>$this->resource['created_at'],
                'updated_at'=>$this->resource['updated_at'], */
                'sort'=>$this->resource['sort'] ,
            ];

            if(isset($this->resource['children']) && count($this->resource['children']))
            {
                //p($this->resource['children']);
                $response['children'] = $this->collection($this->resource['children']);
            }

            if(isset($this->resource['role']) && count($this->resource['role']))
            {
                //p($this->resource['role']);
                $response['role'] = RoleResource::collection($this->resource['role']);
            }

            if(isset($this->resource['meta']) && count($this->resource['meta']))
            {
                //p($this->resource['children']);
                $response['meta'] = $this->resource['meta'];
            }
        }

        if(\is_object($this->resource))
        {
            //p($this->resource);die;
            $response = [
                'id'=>$this->resource->id,
                'parent_id'=>$this->resource->parent_id,
                'deep'=>$this->resource->deep,
                'is_menu'=>$this->resource->is_menu,
                'path'=>$this->resource->path,
                'component'=>$this->resource->component,
                'name'=>$this->resource->name,
                'hidden'=>$this->resource->hidden,
                'alwaysShow'=>$this->resource->alwaysShow,
                'redirect'=>$this->resource->redirect ,
                'meta_title'=>$this->resource->meta_title,
                'meta_roles'=>$this->resource->meta_roles,
                'meta_icon'=>$this->resource->meta_icon,
                'meta_noCache'=>$this->resource->meta_noCache,
                'meta_affix'=>$this->resource->meta_affix,
                'meta_breadcrumb'=>$this->resource->meta_breadcrumb,
                'meta_activeMenu'=>$this->resource->meta_activeMenu,
                'switch'=>$this->resource->switch,
                'created_at'=>$this->resource->created_at,
                'updated_at'=>$this->resource->updated_at,
                'sort'=>$this->resource->sort ,
            ];

            if(isset($this->resource->children) && count($this->resource->children))
            {
                //p($this->resource['children']);
                $response['children'] = $this->collection($this->resource->children);
            }

            if(isset($this->resource->role) && count($this->resource->role))
            {
                //p($this->resource['role']);
                $response['role'] = RoleResource::collection($this->resource->role);
            }

            if(isset($this->resource->meta))
            {
                //p($this->resource['children']);
                $response['meta'] = $this->resource->meta;
            }

          /* if($this->resource->relationLoaded('unionResource'))
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
