<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 10:46:02
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 20:05:59
 * @FilePath: \app\Service\Facade\Admin\System\Group\AdminCategoryFacadeService.php
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

use App\Models\Article\Category;
use App\Models\Article\Union\ArticleCategoryUnion;

use App\Http\Resources\Article\CategoryResource;

/**
 * @see \App\Facade\Admin\System\Group\AdminCategoryFacade
 */
class AdminCategoryFacadeService
{
    public function test()
    {
       echo "AdminCategoryFacadeService test";
    }

    use AlwaysService;

     /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->init((new Category),'deep');
    }

    /**
     * 结合redis获取所有树形地区
     *
     * @return void
     */
    public function getTreeCategory()
    {
        $result = code(config('admin_code.GetCategoryError'));

        $redisTreeCategory = Redis::hget('system:config','treeCategory');

        if($redisTreeCategory)
        {
            $treeCategory = \json_decode($redisTreeCategory,true);
        }
        else
        {
            $treeCategory = $this->getTreeData(['picture']);

            $redisResult = Redis::hset('system:config','treeCategory',json_encode($treeCategory));
        }

        $data['data'] = CategoryResource::collection($treeCategory);

        $result = code(['code'=>0,'msg'=>'获取文章分类成功!'],$data);

        return  $result;
    }

    /**
     *  添加地区
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function addCategory($validated,$admin)
    {
        $result = code(config('admin_code.AddCategoryError'));



        $category = new Category;

        foreach ( $validated as $key => $value)
        {
            if(isset($value))
            {
                $category->$key = $value;
            }
        }

        $category->switch = 1;
        $category->created_time = time();
        $category->created_at = time();

        $categoryResult = $category->save();

        if(!$categoryResult)
        {
            throw new CommonException('AddCategoryError');
        }

        CommonEvent::dispatch($admin,$validated,'AddCategory');

        Redis::hdel('system:config','treeCategory');

        $result = code(['code'=>0,'msg'=>'添加文章分类成功!']);

        return $result;
    }

    /**
     * 更新地区
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function updateCategory($validated,$admin)
    {
        $result = code(config('admin_code.UpdateCategoryError'));

        $category = Category::find($validated['id']);

        if(!$category)
        {
            throw new CommonException('ThisDataHasChildrenError');
        }

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$category ->revision];

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

        $updateData['revision'] = $category ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $categoryResult = Category::where($where)->update($updateData);

        if(!$categoryResult)
        {
            throw new CommonException('UpdateCategoryError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdateCategory');

        Redis::hdel('system:config','treeCategory');

        $result = code(['code'=>0,'msg'=>'修改文章分类成功!']);

        return $result;
    }

    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function moveCategory($validated, $admin)
    {
        $result = code(config('admin_code.MoveCategoryError'));

        $category = Category::find($validated['id']);

        $categoryRevision = $category->revision;

        $oldDeep = $category->deep;

        $parentDeep = 1;

        if ($validated['parent_id'])
        {
            $parentCategory = Category::find($validated['parent_id']);

            $parentDeep = $parentCategory->deep + 1;
        }

        if (self::$dropType[$validated['dropType']] == 10)
        {
            $categoryUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'deep' =>  $parentDeep,
                'revision' => $categoryRevision + 1
            ];
        }

        if (self::$dropType[$validated['dropType']] == 20)
        {
            $categoryUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'sort' => $validated['sort'],
                'deep' => $parentDeep,
                'revision' => $categoryRevision + 1
            ];
        }

        if (self::$dropType[$validated['dropType']] == 30)
        {
            $categoryUpdate = [
                'updated_time' => time(),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'parent_id' => $validated['parent_id'],
                'sort' => $validated['sort'],
                'deep' => $parentDeep,
                'revision' => $categoryRevision + 1
            ];
        }

        $categoryWhere = [['id', '=', $validated['id']], ['revision', '=', $categoryRevision]];

        //更新配置项
        $categoryResult = Category::where($categoryWhere)->update($categoryUpdate);

        if (!$categoryResult)
        {
            throw new CommonException('MoveCategoryError');
        }

        CommonEvent::dispatch($admin, $validated, 'MoveCategory');

        //修改子级deep
        $deepNumber = $parentDeep - $oldDeep;

        $updateDeepResult = $this->updateChildrenDeep($category->id,$deepNumber);

        //清空redis的缓存数据
        $redisTreeResult = Redis::hdel('system:config', 'treeCategory');

        $result = code(['code'=>0,'msg'=>'移动文章分类成功!']);

        return $result;
    }

    /**
     * 删除地区
     *
     * @param [type] $id
     * @param [type] $user
     * @return void
     */
    public function deleteCategory($validated,$admin)
    {
        $result = code(config('admin_code.DeleteCategoryError'));

        //查看是否有子类
        $id = $validated['id'];

        $category = Category::where('parent_id',$id)->get();

        $count = $category->count();

        //有子类不能删除
        if($count)
        {
            throw new CommonException('DeleteNoCategoryError');
        }

        $articleCategoryUnion  = ArticleCategoryUnion::where('category_id',$id)->get();

        $articleCategoryUnionCount = $articleCategoryUnion ->count();

        if($articleCategoryUnionCount)
        {
            throw new CommonException('DeleteNoArticleCategoryError');
        }


        $delCategory = Category::find($id);

        if(!$category)
        {
            throw new CommonException('ThisDataHasChildrenError');
        }

        $delCategory->deleted_time = time();

        $delCategory->deleted_at = time();

        $delCategoryResult =  $delCategory->save();

        if(!$delCategoryResult)
        {
            throw new CommonException('DeleteCategoryError');
        }

        CommonEvent::dispatch($admin, $validated, 'DeleteCategory');

        //清空redis的缓存数据
        $redisTreeResult = Redis::hdel('system:config', 'treeCategory');

        $result = code(['code'=>0,'msg'=>'删除文章分类成功!']);

        return $result;
    }
}
