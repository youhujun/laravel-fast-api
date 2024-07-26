<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 21:54:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 11:38:26
 * @FilePath: \app\Service\Facade\Admin\System\Permission\AdminPermissionFacadeService.php
 */

namespace App\Service\Facade\Admin\System\Permission;

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

use App\Models\System\Permission\Permission;
use App\Models\Admin\Admin;

use App\Http\Resources\System\Permission\PermissionResource;

/**
 * @see \App\Facade\Admin\System\Permission\AdminPermissionFacade
 */
class AdminPermissionFacadeService
{
   public function test()
   {
       echo "AdminPermissionFacadeService test";
   }

   use AlwaysService;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->init((new Permission),'deep');
    }

    /**
     * 重写权限角色菜单的树形数据
     *
     * @return void
     */
    public function getTreeData()
    {
       $admin = Auth::guard('admin_token')->user();

       //获取所有等级数组
       /**
        * Array(    [0] => 1    [1] => 2    [2] => 3    [3] => 4)
        */
       $tree = $this->getAllTree();


       //将不同等级数据分别装入容器
       for ($i = 0; $i < count($tree); $i++)
       {
           //查询每一个级别的菜单和可用的
           if($admin->isDevelop())
           {
                $deepData =  self::$modle::with('role')->select($this->selectField)->where([[self::$field,$tree[$i]],['is_menu',1]])->orderBy($this->sortField)->orderBy('sort','desc')->get()->toArray();
           }
           else
           {
                $deepData =  self::$modle::with('role')->select($this->selectField)->where([[self::$field,$tree[$i]],['is_menu',1],['switch',1]])->orderBy($this->sortField)->orderBy('sort','desc')->get()->toArray();
           }

           //处理每一个菜单的参数
           //菜单角色处理
          \array_walk($deepData,function(&$v)
          {
                $arrRole = [];
                array_map(function($value) use(&$arrRole)
                {
                    $arrRole[] = $value['logic_name'];

                },$v['role']);

                //菜单meta处理
                $meta = [
                    'title'=>$v['meta_title'],
                    'roles'=>$arrRole,
                    'icon'=>$v['meta_icon'],
                    'noCache'=>$v['meta_noCache'],
                    'affix'=>$v['meta_affix'],
                    'breadcrumb'=>$v['meta_breadcrumb'],
                    'activeMenu'=>$v['meta_activeMenu'],
                ];

                $v['meta'] = $meta;
          });

          //将每一级菜单赋值给属性容器
          $this->treeData[$i] = $deepData;
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
                     $v['children'][] = $value;
                  }
               }
           }
       }
       return $this->treeData[0];

    }

    /**
     * 获取树形权限菜单
     *
     * @return void
     */
    public function getTreePermission(Admin $admin)
    {
        $result = [];

        if($admin->isDevelop())
        {
            $checkResult =  Redis::hexists('system:config','develop_permission');
        }
        else
        {
            $checkResult =  Redis::hexists('system:config','permission');
        }

        //定义树形结构容器
        $treePermission = [];

        if($checkResult)
        {
            if($admin->isDevelop())
            {
                $redisPermission = Redis::hget('system:config','develop_permission');
            }
            else
            {
                $redisPermission = Redis::hget('system:config','permission');
            }

            $treePermission = json_decode( $redisPermission );
        }
        else
        {
            $treePermission = $this->getTreeData();

            if($admin->isDevelop())
            {
                 Redis::hset('system:config','develop_permission',json_encode($treePermission));
            }
            else
            {
                 Redis::hset('system:config','permission',json_encode($treePermission));
            }
        }

        $data = [];

        $treePermission = PermissionResource::collection($treePermission);

        $data['data'] = $treePermission;

        $result = code(['code'=>0,'msg'=>'获取树形路由成功!'],$data);

        return $result;
    }


    /**
     * 添加菜单
     *
     * @param [type] $data
     * @return void
     */
    public function addMenu($validated,$admin)
    {
        $result = code(config('admin_code.AddMenuError'));

        $permission = new Permission;

        foreach ( $validated as $key => $value)
        {
            if(\is_null($value))
            {
                $value = "";
            }

            $permission->$key = $value;
        }

        $permission->switch = 1;

        $permission->created_time = time();

        $permissionResult = $permission->save();

        if(!$permissionResult)
        {
            throw new CommonException('AddMenuError');
        }

        CommonEvent::dispatch($admin,$validated,'AddMenu');

        //清空redis的缓存数据
        Redis::hdel('system:config','permission');
        Redis::hdel('system:config','develop_permission');

        $result = code(['code'=>0,'msg'=>'添加菜单成功!']);

        return $result;
    }

    /**
     * 更新菜单
     *
     * @param [type] $validated
     * @return void
     */
    public function updateMenu($validated,$admin)
    {
        $result = code(config('admin_code.UpdateMenuError'));

        $permission =  Permission::find($validated['id']);

        if(!optional($permission))
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        //查看级别是否变化
        $type = 0;

        foreach ($validated as $key => $value)
        {
            if($key === 'id')
            {
                continue;
            }

            if($key === 'deep' )
            {
                if($permission->$key < $value)
                {
                    //增加级别 实际是变成子级
                    $type = 1;
                }

                if($permission->$key > $value)
                {
                    //减少级别 实际是提升级别
                    $type = 2;
                }
            }

            if(\is_null($value) || empty($value))
            {
                $value = " ";
            }

            $permission->$key = $value;
        }

        $permission->updated_time = time();

        $permission->updated_at = time();

        $permissionResult = $permission->save();

        if(!$permissionResult)
        {
            throw new CommonException('UpdateMenuError');
        }

        $childrenData = $this->getAllChildren($validated['id']);

        $updateChildrenResult = 1;

        if($type == 1)
        {
            $updateChildrenResult = $this->updateChildrenDeep( $childrenData['data'],1);
        }

        if($type == 2)
        {
            $updateChildrenResult = $this->updateChildrenDeep( $childrenData['data'],0);
        }

        if(!$updateChildrenResult)
        {
            throw new CommonException('UpdateMenuDeepError');
        }

        $eventResult = CommonEvent::dispatch($admin,$validated,'UpdateMenu');

         //清空redis的缓存数据
        Redis::hdel('system:config','permission');
        Redis::hdel('system:config','develop_permission');

        $result = code(['code'=>0,'msg'=>'更新菜单成功!']);

        return $result;
    }

    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function moveMenu($validated,$admin)
    {
        $result = code(config('admin_code.MoveMenuError'));

        $permission = Permission::find($validated['id']);

        if(!optional($permission))
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $permissionRevision = $permission->revision;

        $oldDeep = $permission->deep;

        $parentDeep = 1;

        if($validated['parent_id'])
        {
            $parentPermission = Permission::find($validated['parent_id']);

            $parentDeep = $parentPermission->deep + 1;
        }


        if(self::$dropType[$validated['dropType']] == 10)
        {
           $permissionUpdate = [
                'updated_time'=>time(),
                'updated_at'=>date('Y-m-d H:i:s',time()),
                'parent_id' => $validated['parent_id'],
                'deep' => $parentDeep,
                'revision'=>$permissionRevision  + 1
            ];
        }

        if(self::$dropType[$validated['dropType']] == 20)
        {
           $permissionUpdate = [
                'updated_time'=>time(),
                'updated_at'=>date('Y-m-d H:i:s',time()),
                'parent_id' => $validated['parent_id'],
                'sort'=> $validated['sort'],
                'deep'=> $parentDeep,
                'revision'=>$permissionRevision  + 1
            ];
        }

        if(self::$dropType[$validated['dropType']] == 30)
        {
           $permissionUpdate = [
                'updated_time'=>time(),
                'updated_at'=>date('Y-m-d H:i:s',time()),
                'parent_id' => $validated['parent_id'],
                'sort'=> $validated['sort'],
                'deep'=> $parentDeep,
                'revision'=>$permissionRevision  + 1
            ];
        }

       $permissionWhere = [['id','=',$validated['id']],['revision','=',$permissionRevision]];

        //更新配置项
       $permissionResult = Permission::where($permissionWhere)->update($permissionUpdate);

        if(!$permissionResult)
        {
            throw new CommonException('MoveMenuError');
        }

        //修改子级deep
        $deepNumber = $parentDeep - $oldDeep;

        $updateDeepResult = $this->updateChildrenDeep($permission->id,$deepNumber);

        if(!$updateDeepResult)
        {
            throw new CommonException('MoveMenuDeepError');
        }

        CommonEvent::dispatch($admin,$validated,'MoveMenu');

        //清空redis的缓存数据
        Redis::hdel('system:config','permission');
        Redis::hdel('system:config','develop_permission');

        $result = code(['code'=>0,'msg'=>'移动菜单成功!']);

        return $result;
    }

    /**
     * 删除菜单
     *
     * @param [type] $id
     * @return void
     */
    public function deleteMenu($validated,$admin)
    {
        $result = code(config('admin_code.DeleteMenuError'));

        //删除菜单之前要查看是否有子级菜单
        $permission = Permission::where('parent_id',$validated['id'])->get();

        $count = $permission->count();

        if($count)
        {
            throw new CommonException('ThisDataHasChildrenError');
        }

        if($count == 0)
        {
            $delPermission = Permission::find($validated['id']);

            if(!optional($permission))
            {
                throw new CommonException('ThisDataNotExistsError');
            }

            $delPermission->deleted_time = time();

            $delPermission->deleted_at = date('Y-m-d H:i:s',time());

            $delPermissionResult =  $delPermission->save();

            if(!$delPermissionResult)
            {
                throw new CommonException('DeleteMenuError');
            }

            CommonEvent::dispatch($admin,$validated,'DeleteMenu');

            //清空redis的缓存数据
            Redis::hdel('system:config','permission');
            Redis::hdel('system:config','develop_permission');

            $result = code(['code'=>0,'msg'=>'删除菜单成功!']);
        }

        return $result;
    }

    /**
     * 禁用或者开启
     *
     * @param [type] $id
     * @return void
     */
    public function switchMenu($validated,$admin)
    {
        $result = code(config('admin_code.DisableMenuError'));

        $eventName = 'DisableMenu';

        if($validated['switch'])
        {
            $result = code(config('admin_code.AbleMenuError'));

            $eventName = 'AbleMenu';
        }

        $where = [];
        $updateData = [];

        $permission = Permission::find($validated['id']);

        if(!optional($permission))
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        //获取子级数据
        $childrenData = $this->getAllChildren($validated['id']);

        if(isset( $childrenData['idData']))
        {
             array_push($childrenData['idData'],$validated['id']);
        }

        $updateData = [
            'updated_time'=>time(),
            'updated_at'=>\date('Y-m-d H:i:s',time()),
            'switch'=>$validated['switch']
        ];

        $permissionResult = Permission::whereIn('id',$childrenData['idData'])->update($updateData);

        if(!$permissionResult)
        {
            if($validated['switch'])
            {
                throw new CommonException('AbleMenuError');
            }

            throw new CommonException('DisableMenuError');
        }

        CommonEvent::dispatch($admin,$validated,$eventName);

        //清空redis的缓存数据
        Redis::hdel('system:config','permission');
        Redis::hdel('system:config','develop_permission');

        $result = code(['code'=>0,'msg'=>'禁用菜单成功!']);

        if($validated['switch'])
        {
             $result = code(['code'=>0,'msg'=>'开启菜单成功!']);
        }

        return $result;
    }
}
