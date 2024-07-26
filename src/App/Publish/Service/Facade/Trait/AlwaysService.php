<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-09-06 20:16:53
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 22:05:29
 */

namespace App\Service\Facade\Trait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

Trait AlwaysService
{

   //移动类型
   protected static $dropType = ['inner'=>10,'before'=>20,'after'=>30];

    /**
     * 定义的静态模型
     *
     * @var [type]
     */
   protected static $modle;

   /**
    * 定义的静态字段
    */
   protected static $field;

   /**
    * 返回结果要显示的字段
    *
    * @var [type]
    */
   protected $selectField;

   //排序字段
   protected $sortField;

    //排序方式
   protected $sortOrder;

   //所有不同等级数据容器
   protected $treeData = [];


   /**
    * 初始化 用来在继承的子类构造函数中执行
    *
    * @param Model $Model
    * @param string $field
    * @return void
    */
   public function init(Model $Model,$field='deep',$selectField = '*',$sortField= 'id',$sortOrder = 'asc')
   {
        self::$modle = $Model;

        self::$field = $field;

        $this->selectField = $selectField;

        $this->sortField = $sortField;

        $this->sortOrder = $sortOrder;
   }
   /**
    * 获取所有的等级
    *
    * @param Model $Model 传入的模型实例
    * @param string $field 字段名称
    * @return void
    */
   private function getAllTree($with=[])
   {
       //查询所有的所有的等级
       if(count($with) >0 )
       {
            $allTreeArray = self::$modle::with($with)->select(self::$field)->orderBy($this->sortField)->get()->toArray();
       }
       else
       {
            $allTreeArray = self::$modle::select(self::$field)->orderBy($this->sortField)->get()->toArray();
       }

       $allTree =[];

       //转换二位数组
       $allTree = \array_map(function($value)
       {
            return $value[self::$field];
       }, $allTreeArray);

       //去除重复的值
       $perpareTree = array_unique($allTree);

       $tree = [];

       //重新定义键值 从0开始
       $tree = \array_values($perpareTree);

       //确保从低到高排序
       sort($tree);

       return $tree;
   }


    /**
     * 递归查找子级
     *
     * @param [array] $idArray 本地处理容器
     * @param [type] $idData 子级id容器
     * @param [type] $data 子级数据
     * @return void
     */
    public function getRecursionChildren($idArray = [],&$idData =[],&$data= [])
    {

        $childPermission = self::$modle::select($this->selectField)->whereIn('parent_id',$idArray)->get();

        $idArray = [];

        if($childPermission->count() > 0)
        {
            foreach($childPermission as $k => &$v)
            {
                \array_push($idArray,$v->id);
                \array_push($idData,$v->id);
                \array_push($data,$v);
            }

            $this->getRecursionChildren($idArray,$idData,$data);
        }

        return ['idData'=>$idData,'data'=>$data];

    }

   /**
    * 获取等级树形数据
    *
    * @param Model $Model
    * @param string $field
    * @return void
    */
   public function getTreeData($with=[])
   {

       //获取所有等级数组
       $tree = $this->getAllTree();

       $data = [];

       if($tree && count($tree) > 0)
       {
            //将不同等级数据分别装入容器
            for ($i = 0; $i < count($tree); $i++)
            {
                if(count($with) > 0)
                {

                    $this->treeData[$i] =  self::$modle::with($with)->select($this->selectField)->where(self::$field,$tree[$i])->orderBy($this->sortField)->orderBy('sort','desc')->get()->toArray();
                }
                else
                {

                    $this->treeData[$i] =  self::$modle::where(self::$field,$tree[$i])->select($this->selectField)->orderBy($this->sortField)->orderBy('sort','desc')->get()->toArray();
                }

            }

            //从倒数第二级开始,将最后一级绑定到上面 ,然后依次类推,最后得到树形数据
            for ($i=count($tree); $i>1; $i--)
            {
                foreach ($this->treeData[$i-2] as $k => &$v)
                {

                    $v['children'] = [];

                    foreach ($this->treeData[$i-1] as $key => &$value)
                    {
                        if($value['parent_id'] == $v['id'])
                        {
                            array_push($v['children'],$value);
                        }
                    }
                }
            }

            $data = $this->treeData[0];

       }

       return $data;
   }

   /**
    * 获取链条排列的所有数据
    *
    * @param Model $Model
    * @return void
    */
   public function getAllData()
   {
        $allData = self::$modle::select($this->selectField)->get();

        return $allData->toArray();
   }

   /**
    *
    * 根绝id 查找所有子级数据 注意不是树形,是为了批量修改数据
    * @param [type] $id 父级id
    * @return void ['idData'=>$idData,'data'=>$data];
    */
   public function getAllChildren($id)
    {
        $idArray = [$id];

        $idData = [];

        $data = [];

        $result = $this->getRecursionChildren($idArray,$idData,$data);

        return $result;

    }

    /**
     * Undocumented function
     *
     * @param [type] $parent_id 父级id
     * @param integer $deepNumber 要修改的级别深度
     * @return void
     */
    public function updateChildrenDeep($parent_id,$deepNumber = 0)
    {
        $result = 1;

        $allChildren = $this->getAllChildren($parent_id);

        if(isset($allChildren['data']) && count($allChildren['data']))
        {
            $data = $allChildren['data'];

            foreach($data as $k => $v)
            {

                $v->{self::$field}  = $v->{self::$field}  + $deepNumber;

                $v->updated_time = time();

                $v->updated_at = time();

                $updateReult = $v->save();

                if(!$updateReult)
                {
                    $result = 0;
                }
            }
        }

        return $result;
    }
}
