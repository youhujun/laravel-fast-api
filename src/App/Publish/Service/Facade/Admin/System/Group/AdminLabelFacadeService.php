<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 10:46:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 21:16:18
 * @FilePath: \app\Service\Facade\Admin\System\Group\AdminLabelFacadeService.php
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

use App\Models\Help\Label;
use App\Models\Article\Union\ArticleLabelUnion;

use App\Http\Resources\Help\LabelRecource;

/**
 * @see \App\Facade\Admin\System\Group\AdminLabelFacade
 */
class AdminLabelFacadeService
{
   public function test()
   {
       echo "AdminLabelFacadeService test";
   }

   use AlwaysService;

      /**
    * Label constructor.
    */
    public function __construct()
    {
        $this->init((new Label),'deep');
    }

    /**
     * 结合redis获取所有树形地区
     *
     * @return void
     */
    public function getTreeLabel()
    {
        $result = code(config('admin_code.GetLabelError'));

        $redisTreeLabel = Redis::hget('system:config','treeLabel');

        if($redisTreeLabel)
        {
            $treeLabel = \json_decode($redisTreeLabel,true);
        }
        else
        {
            $treeLabel = $this->getTreeData(['picture']);

            $redisResult = Redis::hset('system:config','treeLabel',json_encode($treeLabel));
        }

        $data['data'] = LabelRecource::collection($treeLabel);

        $result = code(['code'=>0,'msg'=>'获取树形标签成功!'],$data);

        return  $result;
    }

    /**
     *  添加地区
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function addLabel($validated,$admin)
    {
        $result = code(config('admin_code.AddLabelError'));

        $label = new Label;

        foreach ( $validated as $key => $value)
        {
            if(\is_null($value))
            {
                $value = "";
            }

           $label->$key = $value;
        }

       $label->created_time = time();
       $label->created_at = time();
       $label->switch = 1;

       $labelResult =$label->save();

        if(!$labelResult)
        {
            throw new CommonException('AddLabelError');
        }

        CommonEvent::dispatch($admin,$validated,'AddLabel');

        //清除缓存
        Redis::hdel('system:config','treeLabel');

        $result = code(['code'=>0,'msg'=>'添加标签成功!']);

        return $result;
    }

    /**
     * 更新地区
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function updateLabel($validated,$admin)
    {
        $result = code(config('admin_code.UpdateLabelError'));

        $label = Label::find($validated['id']);

        if(!$label)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$label->revision];

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

            $updateData[$key] = $value;

        }

        $updateData['revision'] = $label ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $labelResult = Label::where($where)->update($updateData);

        if(!$labelResult)
        {
            throw new CommonException('UpdateLabelError');
        }

        $eventResult = CommonEvent::dispatch($admin,$validated,'UpdateLabel');

        //清除缓存
        Redis::hdel('system:config','treeLabel');

        $result = code(['code'=>0,'msg'=>'更新标签成功!']);

        return $result;
    }

    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function moveLabel($validated, $admin)
    {
        $result = code(config('admin_code.MoveLabelError'));

        $label = Label::find($validated['id']);

        if(!$label)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $labelRevision = $label->revision;

        $oldDeep = $label->deep;

        $parentDeep = 1;

        if ($validated['parent_id'])
        {
            $parentLabel = Label::find($validated['parent_id']);

            $parentDeep = $parentLabel->deep + 1;
        }

        if (self::$dropType[$validated['dropType']] == 10)
        {
            $labelUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'deep' =>  $parentDeep,
                'revision' => $labelRevision + 1
            ];
        }

        if (self::$dropType[$validated['dropType']] == 20)
        {
            $labelUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'sort' => $validated['sort'],
                'deep' => $parentDeep,
                'revision' => $labelRevision + 1
            ];
        }

        if (self::$dropType[$validated['dropType']] == 30)
        {
            $labelUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'sort' => $validated['sort'],
                'deep' => $parentDeep,
                'revision' => $labelRevision + 1
            ];
        }

        $labelWhere = [['id', '=', $validated['id']], ['revision', '=', $labelRevision]];

        //更新配置项
        $labelResult = Label::where($labelWhere)->update($labelUpdate);

        if (!$labelResult)
        {
            throw new CommonException('MoveLabelError');
        }

        CommonEvent::dispatch($admin, $validated, 'MoveLabel');

        //修改子级deep

        //分析 如果现在深度- 以前深度 =0 说敏级别没变  >0 级别变小  <0 级别变大
        $deepNumber = $parentDeep - $oldDeep;

        $updateDeepResult = $this->updateChildrenDeep($label->id,$deepNumber);

       // DB::commit();

        //清空redis的缓存数据
        $redisTreeResult = Redis::hdel('system:config', 'treeLabel');

        $result = code(['code'=>0,'msg'=>'移动标签成功!']);

        return $result;
    }

    /**
     * 删除地区
     *
     * @param [type] $id
     * @param [type] $user
     * @return void
     */
    public function deleteLabel($validated,$admin)
    {
        $result = code(config('admin_code.DeleteLabelError'));

        $id = $validated['id'];
        //查看是否有子类
        $label = Label::where('parent_id',$id)->get();

        $count =$label->count();

        if($count)
        {
            throw new CommonException('DeleteNoLabelError');
        }

        $articleLabelUnion = ArticleLabelUnion::where('label_id',)->get();

        $articleLabelUnionCount = $articleLabelUnion->count();

        if($articleLabelUnionCount)
        {
            throw new CommonException('DeleteNoArticleLabelError');
        }

        $delLabel = Label::find($id);

        $delLabel->deleted_time = time();

        $delLabel->deleted_at = time();

        $delLabelResult =  $delLabel->save();

        if(!$delLabelResult)
        {
            //DB::rollBack();
            throw new CommonException('DeleteLabelError');
        }

        $eventResult = new CommonEvent($admin,$validated,'DeleteLabel');

        //清除缓存
        Redis::hdel('system:config','treeLabel');

        $result = code(['code'=>0,'msg'=>'删除标签成功!']);

        return $result;
    }
}
