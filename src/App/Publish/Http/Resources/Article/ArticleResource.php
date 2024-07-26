<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 11:45:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 20:38:35
 * @FilePath: \app\Http\Resources\Article\ArticleResource.php
 */

namespace App\Http\Resources\Article;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Article\CategoryResource;
use App\Http\Resources\Help\LabelRecource;

class ArticleResource extends JsonResource
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

        /* if(\is_array($this->resource))
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
                'admin_id'=>$this->resource->admin_id,
                'user_id'=>$this->resource->user_id,
                'title'=>$this->resource->title,
                'status'=>$this->resource->status,
                'type'=>$this->resource->type,
                'is_top'=>$this->resource->is_top,
                'check_status'=>$this->resource->check_status,
                'published_at'=>$this->resource->published_at,
                'checked_at'=>$this->resource->checked_at,
                'created_at'=>$this->resource->created_at,
                'updated_at'=>$this->resource->updated_at,
                'category_id'=>json_decode($this->resource->category_id,true),
                'label_id'=>$this->resource->label_id?json_decode($this->resource->label_id,true):[],
                'sort'=>$this->resource->sort,
            ];

            if($this->resource->relationLoaded('articleInfo'))
            {
                if(!is_null($this->resource))
                {

                    $articleInfo = $this->resource->articleInfo;

                    $response['content'] = $articleInfo->article_info;
                }
            }

            if($this->resource->relationLoaded('admin'))
            {

                if(!is_null($this->resource))
                {
                    $admin = $this->resource->admin;

                    if($admin->relationLoaded('user'))
                    {
                         $user = $this->resource->admin->user;

                         if($user->relationLoaded('userInfo'))
                         {
                             $userInfo = $user->userInfo;

                             $response['admin_account_name'] = $admin->account_name;
                             $response['admin_phone'] = $admin->phone;
                             $response['admin_nick_name'] = $userInfo->nick_name;
                         }
                    }
                }
            }

            if($this->resource->relationLoaded('user'))
            {
                if(!is_null($this->resource))
                {
                    $user = $this->resource->user;

                    if(!is_null($user))
                    {
                        if($user->relationLoaded('userInfo'))
                         {
                             $userInfo = $user->userInfo;

                             $response['user_account_name'] = $user->account_name;
                             $response['user_phone'] = $user->phone;
                             $response['user_nick_name'] = $userInfo->nick_name;
                         }
                    }

                }
            }

            if($this->resource->relationLoaded('category'))
            {
               $categoryColleciton =  $this->resource->category;

               CategoryResource::setUseType(10);

               $response['category'] = CategoryResource::collection($categoryColleciton);
            }

            if($this->resource->relationLoaded('label'))
            {
               $labelColleciton =  $this->resource->label;

               LabelRecource::setUseType(10);

               $response['label'] = LabelRecource::collection($labelColleciton);

            }

            /* if($this->resource->relationLoaded('unionResource'))
            {
                if(!is_null($this->resource))
                {
                    $response['union_rescource'] = new ReplaceUnionResource($this->resource);
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
