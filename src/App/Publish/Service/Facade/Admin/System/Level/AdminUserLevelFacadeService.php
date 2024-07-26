<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 22:36:08
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-27 22:13:17
 * @FilePath: \app\Service\Facade\Admin\System\Level\AdminUserLevelFacadeService.php
 */

namespace App\Service\Facade\Admin\System\Level;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\User\UserLevel;
use App\Models\User\Union\UserLevelItemUnion;

use App\Http\Resources\System\Level\UserLevelResource;
use App\Http\Resources\System\Level\UserLevelCollection;

use App\Service\Facade\Trait\QueryService;
/**
 * @see \App\Facade\Admin\System\Level\AdminUserLevelFacade
 */
class AdminUserLevelFacadeService
{
   public function test()
   {
       echo "AdminUserLevelFacadeService test";
   }

       use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

   protected static $searchItem = [
        'level_name',
        'level_code'
    ];

   protected static $storage_public_path = DIRECTORY_SEPARATOR.'app'. DIRECTORY_SEPARATOR.'public';

    /**
     * 获取常用
     *
     * @param [type] $user
     * @return void
     */
    public function defaultUserLevel()
    {
        $result = code(config('admin_code.DefaultUserLevelError'));

        $this->where = [];

        $userLevelList = UserLevel::where($this->where)->orderBy('sort','desc')->orderBy('created_at','asc')->get();

        if(!optional($userLevelList))
        {
            throw new CommonException('DefaultUserLevelError');
        }

        $result = new UserLevelCollection( $userLevelList,['code'=>0,'msg'=>'获取默认用户级别成功!']);

        return  $result;

    }

    /**
     * 搜索查找选项
     *
     * @param [type] $find
     * @return void
     */
    public function findUserLevel($validated)
    {
        $result = code(config('admin_code.FindUserLevelError'));

        $this->where[] = ['level_name','like',"%{$validated['find']}%"];

        $userLevelList = UserLevel::where($this->where)->orderBy('sort','desc')->orderBy('created_at','asc')->get();

        if(!optional($userLevelList))
        {
            throw new CommonException('FindUserLevelError');
        }

        $result = new UserLevelCollection( $userLevelList,['code'=>0,'msg'=>'查找用户级别成功!']);

        return  $result;
    }

    /**
     * 查询
     *
     * @param [type] $validated
     * @return void
     */
    public function getUserLevel($validated)
    {

       $result = code(config('admin_code.GetUserLevelError'));

       $this->setQueryOptions($validated);

       $query =UserLevel::with(['levelItem','background']);

       if(isset($validated['findSelectIndex']))
       {
            if(isset($validated['find']) && !empty($validated['find']))
            {
               $this->where[] = [self::$searchItem[$validated['findSelectIndex']],'like',"%{$validated['find']}%"];

               $query =UserLevel::where($this->where);
            }
       }

        if(isset($validated['timeRange']) && \count($validated['timeRange']) > 0)
        {
            if(isset($validated['timeRange'][0]) && !empty($validated['timeRange'][0]))
            {
                $this->whereBetween[] = [\strtotime($validated['timeRange'][0])];
            }

            if(isset($validated['timeRange'][1]) && !empty($validated['timeRange'][1]))
            {
                $this->whereBetween[] = [\strtotime($validated['timeRange'][1])];
            }

            if(isset($this->whereBetween) && count($this->whereBetween) > 0)
            {
                $query->whereBetween('created_time',$this->whereBetween);
            }

        }

        $query->orderBy('id','asc');

        if(isset($validated['sortType']))
        {
            $sortType = $validated['sortType'];

            $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }


        $userLevelList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(\optional($userLevelList))
        {
            $result = new UserLevelCollection($userLevelList,['code'=>0,'msg'=>'获取用户级别成功!']);
        }

        return  $result;
    }

    /**
     * 添加
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function addUserLevel($validated,$admin)
    {

        $result = code(config('admin_code.AddUserLevelError'));

        $userLevel = new UserLevel;

        foreach ( $validated as $key => $value)
        {
            if(\is_null($value))
            {
                $value = "";
            }

            $userLevel->$key = $value;
        }

        $userLevel->created_time = time();
        $userLevel->created_at = time();

        $userLevelResult = $userLevel->save();

        if(!$userLevelResult)
        {
            throw new CommonException('AddUserLevelError');
        }

        CommonEvent::dispatch($admin,$userLevel,'AddUserLevel');

        $result = code(['code'=>0,'msg'=>'添加用户级别成功!']);

        return $result;
    }


    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updateUserLevel($validated,$admin)
    {
        $result = code(config('admin_code.UpdateUserLevelError'));

        $userLevel = UserLevel::find($validated['id']);

        if(!$userLevel)
        {
            throw new CommonException('ThisDataHasChildrenError');
        }

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$userLevel ->revision];

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

        $updateData['revision'] = $userLevel ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $userLevelResult = UserLevel::where($where)->update($updateData);

        if(!$userLevelResult)
        {
           throw new CommonException('UpdateUserLevelError');
        }

        CommonEvent::dispatch($admin,$userLevel,'UpdateUserLevel');


        $result = code(['code'=>0,'msg'=>'修改用户级别成功!']);

        return $result;
    }


    /**
     * 删除
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function deleteUserLevel($validated,$admin)
    {
        $result = code(config('admin_code.DeleteUserLevelError'));


        $userLevel = UserLevel::find($validated['id']);

        if(!$userLevel)
        {
            throw new CommonException('ThisDataHasChildrenError');
        }

        $userLevel->deleted_time = time();

        $userLevel->deleted_at = time();

        $userLevelResult =  $userLevel->save();

        if(!$userLevelResult )
        {
            throw new CommonException('DeleteUserLevelError');
        }

        CommonEvent::dispatch($admin,$validated['id'],'DeleteUserLevel');

        $result = code(['code'=>0,'msg'=>'删除用户级别成功!']);

        return $result;
    }

    /**
     * 批量删除用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function MultipleDeleteUserLevel($validated,$admin)
    {
        $result = code(config('admin_code.MultipleDeleteUserLevelError'));

        if(isset($validated['selectId']) && count($validated['selectId']))
        {
            $deleteResult = UserLevel::whereIn('id',$validated['selectId'])->delete();

            if(!$deleteResult)
            {
                throw new CommonException('MultipleDeleteUserLevelError');
            }

            CommonEvent::dispatch($admin,$validated,'MultipleDeleteUserLevel');

            $result = code(['code'=>0,'msg'=>'批量删除用户级别成功!']);
        }

        return $result;
    }

    /**
     * \添加用户级别配置项
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function AddUserLevelItemUnion($validated,$admin)
    {
		$result = code(config('admin_code.AddUserLevelItemUnionError'));

        $userLevelItemUnion = new UserLevelItemUnion;

        foreach ( $validated as $key => $value)
        {
            if(\is_null($value))
            {
                $value = "";
            }

            $userLevelItemUnion->$key = $value;
        }

        $userLevelItemUnion->created_time = time();
        $userLevelItemUnion->created_at = time();

        $userLevelItemUnionResult = $userLevelItemUnion->save();

        if(!$userLevelItemUnionResult)
        {
            throw new CommonException('AddUserLevelItemUnionError');
        }

        CommonEvent::dispatch($admin,$userLevelItemUnion,'AddUserLevelItemUnion');

        $result = code(['code'=>0,'msg'=>'添加用户级别配置项成功!']);

        return $result;
    }

    /**
     * 更新 用户级别配置项
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updateUserLevelItemUnion($validated,$admin)
    {
        $result = code(config('admin_code.UpdateUserLevelItemUnionError'));

        $userLevelItemUnion = UserLevelItemUnion::find($validated['id']);

		if(!$userLevelItemUnion)
		{
			throw new CommonException('ThisDataNotExistsError');
		}

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$userLevelItemUnion ->revision];

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

        $updateData['revision'] = $userLevelItemUnion ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $userLevelItemUnionResult = UserLevelItemUnion::where($where)->update($updateData);

        if(!$userLevelItemUnionResult)
        {
           throw new CommonException('UpdateUserLevelError');
        }

        CommonEvent::dispatch($admin,$userLevelItemUnion,'UpdateUserLevel');

        $result = code(['code'=>0,'msg'=>'修改用户级别配置项成功!']);

        return $result;
    }


    /**
     * 删除 用户级别配置项
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function deleteUserLevelItemUnion($validated,$admin)
    {
        $result = code(config('admin_code.DeleteUserLevelItemUnionError'));

        $userLevelItemUnion = UserLevelItemUnion::find($validated['id']);
		
		if(!$userLevelItemUnion)
		{
			throw new CommonException('ThisDataNotExistsError');
		}

        $userLevelItemUnion->deleted_time = time();

        $userLevelItemUnion->deleted_at = time();

        $userLevelItemUnionResult =  $userLevelItemUnion->save();

        if(!$userLevelItemUnionResult )
        {
            throw new CommonException('DeleteUserLevelItemUnionError');
        }

        CommonEvent::dispatch($admin,$validated['id'],'DeleteUserLevelItemUnion');

        $result = code(['code'=>0,'msg'=>'删除用户级别配置项成功!']);

        return $result;
    }
}
