<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 10:42:07
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 20:01:37
 * @FilePath: \app\Service\Facade\Admin\System\Group\AdminGoodsClassFacadeService.php
 */

namespace App\Service\Facade\Admin\System\Group;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Exceptions\Admin\CommonException;
use App\Events\Admin\CommonEvent;

use App\Service\Facade\Trait\AlwaysService;

use App\Models\Goods\GoodsClass;
use App\Models\Goods\Union\GoodsClassUnion;

use App\Http\Resources\Goods\GoodsClassResource;


/**
 * @see \App\Facade\Admin\System\Group\AdminGoodsClassFacade
 */
class AdminGoodsClassFacadeService
{
   public function test()
   {
       echo "AdminGoodsClassFacadeService test";
   }

   use AlwaysService;

   /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->init((new GoodsClass),'deep');
    }

    /**
     * 结合redis获取所有树形地区
     *
     * @return void
     */
    public function getTreeGoodsClass()
    {
        $result = code(config('admin_code.GetGoodsClassError'));

        $redisTreeGoodsClass = Redis::hget('system:config','treeGoodsClass');

        if($redisTreeGoodsClass)
        {
            $treeGoodsClass = json_decode($redisTreeGoodsClass,true);
        }
        else
        {
            $treeGoodsClass = $this->getTreeData(['picture']);

            $redisResult = Redis::hset('system:config','treeGoodsClass',json_encode($treeGoodsClass));
        }

        $data['data'] = [];

        if(count($treeGoodsClass))
        {
            $data['data'] = GoodsClassResource::collection($treeGoodsClass);
        }

        $result = code(['code'=>0,'msg'=>'获取树形产品分类成功'],$data);

        return  $result;
    }

    /**
     *  添加地区
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function addGoodsClass($validated,$admin)
    {
        $result = code(config('admin_code.AddGoodsClassError'));

        $goodsClass = new GoodsClass;

        foreach ( $validated as $key => $value)
        {
            if(isset($value))
            {
                $goodsClass->$key = $value;
            }
        }
        //默认可用
        $goodsClass->switch = 1;
        $goodsClass->created_time = time();
        $goodsClass->created_at = time();

        $goodsClassResult =  $goodsClass->save();

        if(!$goodsClassResult)
        {
           throw new CommonException('AddGoodsClassError');
        }

        CommonEvent::dispatch($admin,$validated,'AddGoodsClass');

        Redis::hdel('system:config','treeGoodsClass');

        $result = code(['code'=>0,'msg'=>'添加产品分类成功']);

        return $result;
    }

    /**
     * 更新地区
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function updateGoodsClass($validated,$admin)
    {
        $result = code(config('admin_code.UpdateGoodsClassError'));

        $goodsClass = GoodsClass::find($validated['id']);

        if(!$goodsClass)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        //查看级别是否变化
        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$goodsClass ->revision];

        foreach ( $validated as $key => $value)
        {
            if($key === 'id')
            {
                $where[] = ['id','=',$value];
                continue;
            }

            if(isset($value))
            {
                $updateData[$key] = $value;

                if($key === 'rate' && $value > 0)
                {
                    $updateData[$key] = \bcdiv($value,100,2);
                }
            }
        }

        $updateData['revision'] = $goodsClass ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $goodsClassResult = GoodsClass::where($where)->update($updateData);

        if(!$goodsClassResult)
        {
           throw new CommonException('UpdateGoodsClassError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdateGoodsClass');

        Redis::hdel('system:config','treeGoodsClass');

        $result = code(['code'=>0,'msg'=>'更新产品分类成功!']);

        return $result;
    }

    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function moveGoodsClass($validated, $admin)
    {
        $result = code(config('admin_code.MoveClassError'));

        $goodsClass = GoodsClass::find($validated['id']);

        if(!$goodsClass)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $goodsClassRevision = $goodsClass->revision;

        $oldDeep = $goodsClass ->deep;

        //元素自己本身的深度
        $parentDeep = 1;

        //如果有父级 就用父级元素
        if ($validated['parent_id'])
        {
            $parentClass = GoodsClass::find($validated['parent_id']);

            $parentDeep = $parentClass->deep + 1;
        }

        if (self::$dropType[$validated['dropType']] == 10)
        {
            $goodsClassUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'deep' =>  $parentDeep,
                'revision' => $goodsClassRevision + 1
            ];
        }

        if (self::$dropType[$validated['dropType']] == 20)
        {
            $goodsClassUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'sort' => $validated['sort'],
                'deep' => $parentDeep,
                'revision' => $goodsClassRevision + 1
            ];
        }

        if (self::$dropType[$validated['dropType']] == 30)
        {
            $goodsClassUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'sort' => $validated['sort'],
                'deep' => $parentDeep,
                'revision' => $goodsClassRevision + 1
            ];
        }

        $goodsClassWhere = [['id', '=', $validated['id']], ['revision', '=', $goodsClassRevision]];

        //更新配置项
        $goodsClassResult = GoodsClass::where($goodsClassWhere)->update($goodsClassUpdate);

        if(!$goodsClassResult)
        {
            throw new CommonException('MoveGoodsClassError');
        }

        CommonEvent::dispatch($admin, $validated, 'MoveGoodsClass');

        //修改子级deep
        $deepNumber = $parentDeep - $oldDeep;

        $updateDeepResult = $this->updateChildrenDeep($goodsClass->id,$deepNumber);

        //清空redis的缓存数据
        $redisTreeResult = Redis::hdel('system:config', 'treeGoodsClass');

        $result = code(['code'=>0,'msg'=>'移动产品分类成功!']);

        return $result;
    }

    /**
     * 删除地区
     *
     * @param [type] $id
     * @param [type] $user
     * @return void
     */
    public function deleteGoodsClass($validated,$admin)
    {
        $result = code(config('admin_code.DeleteGoodsClassError'));

        $id = $validated['id'];
        //查看是否有子类
        $goos_class = GoodsClass::where('parent_id',$id)->get();

        $count = $goos_class->count();

        if($count)
        {
            throw new CommonException('DeleteHasChildrenError');
        }

        $goodsGoodsClassUnion = GoodsClassUnion::where('goods_class_id',$id)->get();

        $goodsGoodsClassUnionCount = $goodsGoodsClassUnion->count();

        if($goodsGoodsClassUnionCount)
        {
            throw new CommonException('DeleteHasGoodsError');
        }

        $goodsClass = GoodsClass::find($id);

        if(!$goodsClass)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $goodsClass->deleted_time = time();

        $goodsClass->deleted_at = time();

        $delClassResult =  $goodsClass->save();

        if(!$delClassResult)
        {
            throw new CommonException('DeleteGoodsClassError');
        }

        CommonEvent::dispatch($admin,$validated,'DeleteGoodsClass');

        Redis::hdel('system:config','treeGoodsClass');

        $result = code(['code'=>0,'msg'=>'删除分类成功!']);

        return $result;
    }

}
