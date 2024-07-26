<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-10-18 09:49:21
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 04:44:20
 */

namespace App\Service\Facade;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\Replace;

use App\Http\Resources\ReplaceResource;
use App\Http\Resources\ReplaceCollection;

class ReplaceAdminTreeService
{
    use AlwaysService;

     /**
    * Replace constructor.
    */

    /**
     * Replace constructor.
     */
    public function __construct()
    {
        $selectField = [
            '*'
        ];
        $this->init((new Permission),'deep',$selectField);
    }

    /**
     * 结合redis获取所有树形
     *
     * @return void
     */
    public function getTreeReplace()
    {
        $result = code(config('admin_code.GetTreeReplaceError'));

        // $redisTreeReplace = Lredis::hget('system:config','treeReplace');

       /*  if($redisTreeReplace)
        {
            $treeReplace = \json_decode($redisTreeReplace,true);
        }
        else
        {
            $treeReplace = $this->getTreeData(['picture']);

            $redisResult = Lredis::hset('system:config','treeReplace',json_encode($treeReplace));
        } */

        // uiion 为关联查询表的关键字

        $treeReplace = $this->getTreeData(['union']);

        $data = [];

        $treeReplace = ReplaceResource::collection($treeReplace);

        $data['data'] = $treeReplace;

        $result = code(['code'=>0,'msg'=>'获取树形成功!'],$data);

        return  $result;
    }

    /**
     *  添加
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function addReplace($validated,$admin)
    {
        $result = code(config('admin_code.AddReplaceError'));

        $replace = new Replace;

        foreach ( $validated as $key => $value)
        {
            if(\is_null($value))
            {
                $value = "";
            }

             if(is_array($value))
            {
                if(count($value))
                {
                    $value = $value[0];
                }
                else
                {
                    $value = 0;
                }
            }

            $replace->$key = $value;
        }

        $replace->created_time = time();

        $replaceResult = $replace->save();

        if(!$replaceResult)
        {
            throw new CommonException('AddReplaceError');
        }

        CommonEvent::dispatch($admin,$replace,'AddReplace');

        $treeReplace = $this->getTreeData(['picture']);

        $result = code(['code'=>0,'msg'=>'成功!']);

        return $result;
    }

    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function updateReplace($validated,$admin)
    {
        $result = code(config('admin_code.UpdateReplaceError'));

        $replace = Replace::find($validated['id']);

        if(!$replace)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$replace ->revision];

        foreach ( $validated as $key => $value)
        {
            if($key === 'id')
            {
                $where[] = ['id','=',$value];
                continue;
            }

            if(\is_null($value))
            {
                $value = "";
            }

             if(is_array($value))
            {
                if(count($value))
                {
                    $value = $value[0];
                }
                else
                {
                    $value = 0;
                }
            }

            $updateData[$key] = $value;
        }

        $updateData['revision'] = $replace ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = time();

        $replaceResult = Replace::where($where)->update($updateData);

        if(!$replaceResult)
        {
           throw new CommonException('UpdateReplaceError');
        }

        $eventResult = CommonEvent::dispatch($admin,$replace,'UpdateReplace');

        // 预加载 关联查询表的字段名称
        $treeReplace = $this->getTreeData(['union']);

        $data['data'] = $treeReplace;

        $result = code(['code'=>0,'msg'=>'成功!']);

        return $result;
    }

    /**
     * 移动
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function moveReplace($validated, $admin)
    {
        $result = code(config('admin_code.MoveReplaceError'));

        $replace = Replace::find($validated['id']);

        if(!$replace)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $replaceRevision = $replace->revision;

        $oldDeep = $replace->deep;

        $parentDeep = 1;

        if ($validated['parent_id'])
        {
            $parentReplace = Replace::find($validated['parent_id']);

            $parentDeep = $parentReplace->deep + 1;
        }

        if ($validated['dropType'] == 'inner')
        {
            $replaceUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'deep' =>  $parentDeep,
                'revision' => $replaceRevision + 1
            ];
        }

        if ($validated['dropType'] == 'before')
        {
            $replaceUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'sort' => $validated['sort'],
                'deep' => $parentDeep,
                'revision' => $replaceRevision + 1
            ];
        }

        if ($validated['dropType'] == 'after')
        {
            $replaceUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'sort' => $validated['sort'],
                'deep' => $parentDeep,
                'revision' => $replaceRevision + 1
            ];
        }

        $replaceWhere = [['id', '=', $validated['id']], ['revision', '=', $replaceRevision]];

        //更新配置项
        $replaceResult = Replace::where($replaceWhere)->update($replaceUpdate);

        if (!$replaceResult)
        {
            throw new CommonException('MoveReplaceError');
        }

        CommonEvent::dispatch($admin, $validated, 'MoveReplace');

        //修改子级deep
        $deepNumber = $parentDeep - $oldDeep;

        $updateDeepResult = $this->updateChildrenDeep($replace->id,$deepNumber);

        //清空redis的缓存数据
        $redisTreeResult = Lredis::hdel('system:config', 'treeReplace');

        $result = code(['code'=>0,'msg'=>'成功!']);

        return $result;
    }

    /**
     * 删除
     *
     * @param [type] $id
     * @param [type] $user
     * @return void
     */
    public function deleteReplace($validated,$user)
    {
        $result = code(config('admin_code.DeleteReplaceError'));

        //查看是否有子类
        $replace = Replace::where('parent_id',$validated['id'])->get();

        $count = $replace->count();

        if($count > 0)
        {
            throw new CommonException('DeleteNoReplaceError');
        }

         //查看是否有子类,如果有子类需要先删除子类
        $childrenReplaceNumber = Replace::where('parent_id',$validated['id'])->get()->count();

		if($childrenReplaceNumber)
		{
			$childrenReplaceChildrenResult = Replace::where('parent_id',$validated['id'])->delete();

			if(!$childrenReplaceChildrenResult)
			{
				throw new CommonException('DeleteReplaceChildrenError');
			}
		}

        $delReplace = Replace::find($validated['id']);

        if(!$replace)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $delReplace->deleted_time = time();

        $delReplace->deleted_at = time();

        $delReplaceResult =  $delReplace->save();

        if(!$delReplaceResult)
        {
            throw new CommonException('DeleteReplaceError');
        }

        DeleteReplace::dispatch($user,$validated['id'],'DeleteReplace');

        $result = code(['code'=>0,'msg'=>'成功!']);

        return $result;
    }

    /**
     * 获取绑定关联地区
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function getReplaceUnionRegion($validated,$admin)
    {
          $result = code(config('admin_code.ReplaceUnionRegionError'));

          $eplaceRegionArray = ReplaceRegionUnion::where('replace_config_id',$validated['replace_config_id'])->pluck('region_id')->toArray();

          if(count($eplaceRegionArray) || count($eplaceRegionArray) == 0)
          {
            $data['data'] =$eplaceRegionArray;

            $result = code(['code'=>0,'msg'=>'成功!'],$data);
          }

          return $result;
    }

    /**
     *更新绑定关联地区
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updateReplaceUnionRegion($validated,$admin)
    {
         $result = code(config('admin_code.UpdateReplaceUnionRegionError'));

         if(count($validated['region_id_array']))
         {
             //先删除之前绑定的地区
            $eplaceRegionUnionNumber = ReplaceRegionUnion::where('replace_config_id',$validated['replace_config_id'])->get()->count();

            if( $eplaceRegionUnionNumber )
            {
                $eplaceRegionUnionBeforeResult = ReplaceRegionUnion::where('replace_config_id',$validated['replace_config_id'])->forceDelete();

                if(!$eplaceRegionUnionBeforeResult )
                {
                    throw new CommonException('UpdateReplaceUnionRegionError');
                }
            }

             $eplaceRegionUnionData = [];

             foreach ($validated['region_id_array'] as $key => $region_id)
             {
                $eplaceRegionUnionData[] = ['created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'replace_config_id'=>$validated['replace_config_id'],'region_id'=>$region_id];
             }

             $eplaceRegionUnionResult =  ReplaceRegionUnion::insert($eplaceRegionUnionData);

             if(!$eplaceRegionUnionResult)
             {
                throw new CommonException('UpdateReplaceUnionRegionError');
             }

            CommonEvent::dispatch($admin,$validated,'UpdateReplaceUnionRegion');

            $result = code(['code'=>0,'msg'=>'成功!']);

         }

        return  $result;
    }
}
