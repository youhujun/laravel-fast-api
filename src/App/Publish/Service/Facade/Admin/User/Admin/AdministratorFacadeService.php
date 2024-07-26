<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-04 00:23:42
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 22:59:41
 * @FilePath: \app\Service\Facade\Admin\User\Admin\AdministratorFacadeService.php
 */

namespace App\Service\Facade\Admin\User\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Plunar\Plunar;

use App\Service\Facade\Trait\QueryService;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Events\Admin\User\Admin\AddAdministratorEvent;
use App\Events\Admin\User\Admin\UpdateAdministratorEvent;

use App\Models\Admin\Admin;
use App\Models\User\User;
use App\Models\User\Union\UserRoleUnion;

use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Admin\AdminCollection;

use App\Facade\Public\Excel\PublicExcelFacade;

/**
 * @see \App\Facade\Admin\User\Admin\AdministratorFacade
 */
class AdministratorFacadeService
{
   public function test()
   {
       echo "AdministratorFacadeService test";
   }

     use QueryService;

    public static $sort = [
        1 => ['created_time', 'asc'],
        2 => ['created_time', 'desc'],
    ];

    protected static $searchItem = [
        'phone',
        'account_name',
        'nick_name',
        'real_name',
        'id_number'
    ];

    //定义 转换路径时的storage软连接
    protected static $storage = 'storage';

   /**
     * 导出表格数据
     *
     * @param [type] $userList
     * @return void
     */
    protected function exportData($userList)
    {
        $cloumn = [['账号', '手机号', '昵称', '姓名', '身份证号', '性别', '生日', '说明', '注册时间']];

        $data = [];

        foreach ($userList as $key => $value) {
            $list = [];

            $list[] = $value->user->account_name;
            $list[] = $value->user->phone;
            $list[] = $value->user->userInfo->nick_name;
            $list[] = $value->user->userInfo->real_name;
            $list[] = $value->user->userInfo->id_number;

            if ($value->user->userInfo->sex) {
                $list[] = $value->user->userInfo->sex == 1 ? '男' : '女';
            } else {
                $list[] = '未知';
            }

            $list[] =  $value->user->userInfo->solar_birthday_at;
            $list[] =  $value->user->userInfo->introduction;
            $list[] =  $value->user->created_at;

            $data[] =  $list;
        }

        $title = "管理员表";

        PublicExcelFacade::exportExcelData($cloumn, $data, $title, 1);

        return $title;
    }

    /**
     * 查询用户
     *
     * @param [type] $validated
     * @return void
     */
    public function getAdmin($validated)
    {

        $result = code(config('admin_code.GetAdminError'));

        $this->setQueryOptions($validated);

        //先处理关联
        $this->withWhere = ['user', 'user.userInfo', 'user.userAvatar' => function ($query)
        {
            $query->orderBy('created_time', 'desc');
        },  'user.role', 'user.userAvatar.albumPicture'];

        $query = Admin::with($this->withWhere);

        if (isset($validated['switch']))
        {
            $this->where[] = ['switch', '=', $validated['switch']];

            $query->where($this->where);
        }

        if (isset($validated['findSelectIndex']))
        {
            if ($validated['findSelectIndex'] < 2)
             {
                if (isset($validated['find']) && !empty($validated['find']))
                {
                    $withWhere[] = [self::$searchItem[$validated['findSelectIndex']], '=', $validated['find']];

                    $orWithWhere[] = [self::$searchItem[$validated['findSelectIndex']], 'like', "%{$validated['find']}%"];

                    $query->whereHas('user', function (Builder $withQuery) use ($withWhere, $orWithWhere)
                    {
                        $withQuery->where($withWhere)->orWhere($orWithWhere);
                    });
                }
            }
            else
            {
                if ($validated['findSelectIndex'] == 4)
                {
                    $validated['find'] = strrev(ucfirst(strrev(trim($validated['find']))));
                }

                if (isset($validated['find']) && !empty($validated['find']))
                {
                    $withWhere[] = [self::$searchItem[$validated['findSelectIndex']], '=', $validated['find']];

                    $orWithWhere[] = [self::$searchItem[$validated['findSelectIndex']], 'like', "%{$validated['find']}%"];

                    $query->whereHas('user.userInfo', function (Builder $withQuery) use ($withWhere, $orWithWhere) {
                        $withQuery->where($withWhere)->orWhere($orWithWhere);
                    });
                }
            }
        }

        if (isset($validated['timeRange']) && \count($validated['timeRange']) > 0)
        {
            $this->whereBetween[] = [\strtotime($validated['timeRange'][0])];
            $this->whereBetween[] = [\strtotime($validated['timeRange'][1])];

            $query->whereBetween('created_time', $this->whereBetween);
        }

        if (isset($validated['sortType']))
        {
            $sortType = $validated['sortType'];

            $query->orderBy(self::$sort[$sortType][0], self::$sort[$sortType][1]);
        }

        $download = null;

        //判断是否需要导出数据
        if (isset($validated['isExport']) && $validated['isExport'] == 1)
        {
            if (isset($validated['exportType']))
            {
                $userList = null;

                $title = '';
                //本页数据
                if ($validated['exportType'] == 1)
                {
                    $userList = $query->offset(($this->page - 1) * $this->perPage)->limit($this->perPage)->get();

                    $title = $this->exportData($userList);
                }

                if ($validated['exportType'] == 2)
                {
                    $userList = $query->get();

                    $title = $this->exportData($userList);
                }

                $exists = Storage::disk('public')->exists("excel/{$title}.xlsx");

                if ($exists)
                {
                    //return response()->download(public_path("storage/excel/{$title}.xlsx"));

                    $download = asset("storage/excel/{$title}.xlsx");
                }
            }
        }

        $userList = $query->paginate($this->perPage, $this->columns, $this->pageName, $this->page);

        //p($userList);die;

        if (\optional($userList))
        {
            $result = new AdminCollection($userList,['code'=>0,'msg'=>'获取管理员成功!'],$download);
        }

        return  $result;
    }

    /**
     * 添加用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function addAdmin($validated, $admin)
    {
        $result = code(config('admin_code.AddAdminError'));

        $user = User::find($validated['user_id']);

        if(!$user)
        {
            throw new CommonException('AddAdminUserError');
        }

        //先添加管理员
        $addAdmin = new Admin();

        $addAdmin->created_at = time();

        $addAdmin->created_time = time();

        $addAdmin->switch = 1;

        $addAdmin->user_id = $user->id;

        $addAdmin->account_name = $user->account_name;

        $addAdmin->email = $user->email;

        $addAdminResult = $addAdmin->save();

        if (!$addAdminResult)
        {
            throw new CommonException('AddAdminError');
        }

        AddAdministratorEvent::dispatch($admin,$addAdmin,$validated);

        CommonEvent::dispatch($admin, $validated, 'AddAdmin');

        $result = code(['code'=>0,'msg'=>'添加管理员成功!']);

        return $result;
    }


    /**
     * 更新用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updateAdmin($validated, $admin)
    {
        $result = code(config('admin_code.UpdateAdminError'));

        $updateAdmin = Admin::find($validated['id']);

        if(!$updateAdmin)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];
        $where[] = ['id','=',$updateAdmin->id];
        $where[] = ['revision','=',$updateAdmin->revision];

        $updateData = [];

        $updateData = [
            'updated_at' => date('Y-m-d H:i:s',time()),
            'updated_time' => time(),
            'revision' => $updateAdmin->revision + 1,
        ];

        //更新管理员
        $updateAdminResult = Admin::where($where)->update($updateData);

        if (!$updateAdminResult)
        {
            throw new CommonException('UpdateAdminError');
        }

        UpdateAdministratorEvent::dispatch($admin,$updateAdmin,$validated);

        CommonEvent::dispatch($admin, $validated, 'UpdateAdmin');

        $result = code(['code'=>0,'msg'=>'更新管理员成功!']);

        return $result;
    }

    /**
     * 禁用用户
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function disableAdmin($validated, $admin)
    {
        $result = code(config('admin_code.DisableAdminError'));

        $disableAdmin = Admin::find($validated['id']);

        if(!$disableAdmin)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $disableAdminRevision = $disableAdmin->revision;

        $disableAdminUpdateData = ['switch' => 0, 'updated_time' => time(), 'updated_at' => \date('Y-m-d H:i:s', time()), 'revision' => $disableAdminRevision + 1];

        $disableAdminResult = Admin::where('id', $disableAdmin->id)->where('revision', $disableAdminRevision)->update($disableAdminUpdateData);

        if(!$disableAdminResult)
        {
            throw new CommonException('DisableAdminError');
        }

        CommonEvent::dispatch($admin, $validated, 'DisableAdmin');

        $result = code(['code'=>0,'msg'=>'禁用管理员成功!']);

        return $result;
    }



    /**
     * 批量禁用用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDisableAdmin($validated, $admin)
    {
        $result = code(config('admin_code.MultipleDisableAdminError'));

        $checkResult = 0;

        if(in_array(1,$validated['selectId'])||in_array(2,$validated['selectId']))
        {
            $checkResult = 1;
        }

        if ($checkResult)
        {
            throw new CommonException('MultipleDisableSystemAdminError');
        }

        $adminUpdateData = ['switch' => 0, 'updated_time' => time(), 'updated_at' => \date('Y-m-d H:i:s', time())];

        $adminResult = Admin::whereIn('id', $validated['selectId'])->update($adminUpdateData);

        if (!$adminResult)
        {
            throw new CommonException('MultipleDisableAdminError');
        }

        CommonEvent::dispatch($admin, $validated, 'MultipleDisableAdmin');

        $result = code(['code'=>0,'msg'=>'批量禁用管理员成功!']);

        return $result;
    }

    /**
     * 删除管理员
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function deleteAdmin($validated, $admin)
    {
        $result = code(config('admin_code.DeleteAdminError'));

        $deleteAdmin = Admin::find($validated['id']);

        if(!$deleteAdmin)
        {
           throw new CommonException('ThisDataNotExistsError');
        }

        $user_id = $deleteAdmin->user_id;

        $deleteAdmin->deleted_time = time();

        $deleteAdmin->deleted_at = \date('Y-m-d H:i:s', time());

        $deleteAdminResult =  $deleteAdmin->save();

        if (!$deleteAdminResult)
        {
            throw new CommonException('DeleteAdminError');
        }

        $user = User::find($user_id);

        $roleArray = $user->role;

        $roleIdArray = [];

        foreach ($roleArray as $key => $role)
        {
            if ($role->id == 4)
            {
                continue;
            }
            $roleIdArray[] = $role->id;
        }

        if(count($roleIdArray))
        {
            $roleDeleteResult = UserRoleUnion::whereIn('role_id', $roleIdArray)->where('user_id', $user->id)->delete();

            if (!$roleDeleteResult)
            {
                throw new CommonException('DeleteAdminRoleError');
            }
        }

        CommonEvent::dispatch($admin, $validated, 'DeleteAdmin');

        $result = code(['code'=>0,'msg'=>'删除管理员成功!']);

        return $result;
    }

    /**
     * 批量删除用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDeleteAdmin($validated, $admin)
    {
        $result = code(config('admin_code.MultipleDeleteAdminError'));

        $checkResult = 0;

        if(in_array(1,$validated['selectId'])||in_array(2,$validated['selectId']))
        {
            $checkResult = 1;
        }

        if ($checkResult)
        {
            throw new CommonException('MultipleDeleteSystemAdminError');
        }

        $admins = Admin::whereIn('id', $validated['selectId'])->get();

        $deleteResult = Admin::whereIn('id', $validated['selectId'])->delete();

        if (!$deleteResult)
        {
            throw new CommonException('MultipleDeleteAdminError');
        }

        $userIdArray = [];

        $roleIdArray = [];

        foreach ($admins as $key => $adminItem)
        {
            $userIdArray[] = $adminItem->user_id;

            $roleArray = $adminItem->user->role;

            $oneIdArray = [];

            foreach ($roleArray as $key => $role)
            {
                if ($role->id == 4)
                {
                    continue;
                }

                $oneIdArray[] = $role->id;
            }

            $roleIdArray = \array_unique(array_merge($roleIdArray, $oneIdArray));
        }

        $roleResult = UserRoleUnion::whereIn('user_id', $userIdArray)->whereIn('role_id',$roleIdArray)->delete();

        if (!$roleResult)
        {
            throw new CommonException('MultipleDeleteAdminRoleError');
        }

        CommonEvent::dispatch($admin, $validated, 'MultipleDeleteUser');

        $result = code(['code'=>0,'msg'=>'批量删除管理员成功!']);

        return $result;
    }


    /**
     * 获取所有的后台管理员用户
     *
     * @return void
     */
    public function getDefaultAdmin()
    {

        $result = code(config('admin_code.GetDefaultAdminerError'));

        $adminList = Admin::limit(10)->orderBy('id','asc')->get();

        $data = [];

        if (!optional($adminList))
        {
            throw new CommonException('getDefaultAdminerError');
        }

        $data['data'] = AdminResource::collection($adminList);

        $result = code(['code'=>0,'msg'=>'获取默认管理员成功!'], $data);

        return  $result;
    }


    /**
     * 查找管理员
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function findAdmin($validated,$admin)
    {
        $result = code(config('admin_code.FindAdminerError'));

        $where[] = ['account_name','like',"%{$validated['find']}%"];
        $orWhere[] = ['phone','like',"%{$validated['find']}%"];

        $adminList = Admin::where($where)->orWhere($orWhere)->orderBy('created_at','asc')->get();

        if(!optional($adminList))
        {
            throw new CommonException('FindAdminerError');
        }

        $data['data'] = AdminResource::collection($adminList);

        $result = code(['code'=>0,'msg'=>'查找管理员成功!'],$data);

        return  $result;
    }
}
