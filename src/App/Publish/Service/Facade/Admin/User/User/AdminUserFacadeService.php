<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 14:58:02
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 23:14:18
 * @FilePath: \app\Service\Facade\Admin\User\User\AdminUserFacadeService.php
 */

namespace App\Service\Facade\Admin\User\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

//必用
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use App\Service\Facade\Trait\QueryService;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;
use App\Events\Admin\User\User\AddUserEvent;

use App\Models\User\User;
use App\Models\Admin\Admin;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;

use App\Facade\Public\Excel\PublicExcelFacade;

/**
 * @see \Aapp\Facade\Admin\User\User\AdminUserFacade
 */
class AdminUserFacadeService
{
   public function test()
   {
       echo "AdminUserFacadeService test";
   }

    use QueryService;

    protected static $sort = [
      '1'=>['created_time','asc'],
      '2'=>['created_time','desc'],
    ];

    protected static $searchItem = [
        'phone',
        'account_name',
        'nick_name',
        'real_name',
        'id_number'
    ];


    /**
     * 导出表格数据
     *
     * @param [type] $userList
     * @return void
     */
    protected function exportData($userList)
    {
        $cloumn = [['账号','手机号','昵称','姓名','身份证号','性别','生日','说明','注册时间']];

        $data = [];

        foreach ($userList as $key => $value)
        {
           $list = [];

           $list[] = $value->account_name;
           $list[] = $value->phone;
           $list[] = $value->userInfo->nick_name;
           $list[] = $value->userInfo->real_name;
           $list[] = $value->userInfo->id_number;

           if($value->userInfo->sex)
           {
                $list[] = $value->userInfo->sex == 1? '男':'女';
           }
           else
           {
                $list[] = '未知';
           }

           $list[] = $value->userInfo->solar_birthday_at;
           $list[] = $value->userInfo->introduction;
           $list[] = $value->created_at;

           $data[] =  $list;
        }

        $title = "用户表";

        PublicExcelFacade::exportExcelData($cloumn, $data,$title,1);

        return $title;

    }

    /**
     * 查询用户
     *
     * @param [type] $validated
     * @return void
     */
    public function getUser($validated)
    {

       $result = code(config('admin_code.GetUserError'));

       $this->setQueryOptions($validated);

       //先处理关联

      /*  $this->withWhere = ['userInfo','userAvatar'=>function($query){
             $query->orderBy('created_time','desc');
       },'userAvatar.albumPicture','role','userAddress','userAddress.country','userAddress.province','userAddress.region','userApplyRealAuth']; */

        $this->withWhere = ['userInfo','userAvatar'=>function($query){
             $query->orderBy('created_time','desc');
       },'userAvatar.albumPicture','role'];

       $query = User::with($this->withWhere);

       // 判断用户是否禁用
       if(isset($validated['switch']))
       {
            $this->where[] = ['switch','=',$validated['switch']];

            $query->where($this->where);
       }

       // 判断实名认证状态
       if(isset($validated['real_auth_status']) && $validated['real_auth_status'] > 0)
       {
            $withWhere[] = ['real_auth_status','=',$validated['real_auth_status']];

            $query->where($this->where);
       }


       // 搜索用户
       if(isset($validated['findSelectIndex']))
       {
            // 搜索用户的手机号和账户名
            if($validated['findSelectIndex'] < 2)
            {
                if(isset($validated['find']) && !empty($validated['find']))
                {
                    $this->where[] = [self::$searchItem[$validated['findSelectIndex']],'=',$validated['find']];

                    $this->orwhere[] = [self::$searchItem[$validated['findSelectIndex']],'like',"%{$validated['find']}%"];

                    $query->where($this->where)->orWhere($this->orwhere);
                }
            }
            else
            {
                // 搜索用户的 姓名 真实姓名 以及身份证号
                if($validated['findSelectIndex'] == 4)
                {
                    $validated['find'] = strrev(ucfirst(strrev(trim($validated['find']))));
                }
                if(isset($validated['find']) && !empty($validated['find']))
                {
                    $withWhere[] = [self::$searchItem[$validated['findSelectIndex']],'=',$validated['find']];

                    $orWithWhere[] = [self::$searchItem[$validated['findSelectIndex']],'like',"%{$validated['find']}%"];

                    $query->whereHas('userInfo',function(Builder $withQuery)use($withWhere,$orWithWhere){
                    $withQuery->where($withWhere)->orWhere($orWithWhere);
                   });
                }
            }

        }

        if(isset($validated['timeRange']) && \count($validated['timeRange']) > 0)
        {
             $this->whereBetween[] = [\strtotime($validated['timeRange'][0])];
             $this->whereBetween[] = [\strtotime($validated['timeRange'][1])];

             $query->whereBetween('created_time',$this->whereBetween);
        }

        if(isset($validated['sortType']))
        {
            $sortType = $validated['sortType'];

            $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }

        $download = null;

        //判断是否需要导出数据
        if(isset($validated['isExport']) && $validated['isExport'] == 1)
        {
            if(isset($validated['exportType']))
            {
                $userList = null;

                $title = '';
                //本页数据
                if($validated['exportType'] == 10)
                {
                    $userList = $query->offset(($this->page - 1) * $this->perPage)->limit($this->perPage)->get();

                    $title = $this->exportData($userList);
                }

                if($validated['exportType'] == 20)
                {
                    $userList = $query->get();

                    $title = $this->exportData($userList);
                }

                $exists = Storage::disk('public')->exists("excel/{$title}.xlsx");

                if($exists)
                {
                   $download = asset("storage/excel/{$title}.xlsx");
                }

            }

        }

        //统计实名认证待审核数量

        $userApplayRealAuthNumber = 0;

        $where = [];

        $where[] = ['real_auth_status','=',20];

        $userApplayRealAuthNumber = User::where($where)->count();

        $userList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(\optional($userList))
        {
            $result = new UserCollection($userList,['code'=>0,'msg'=>'获取用户列表成功!'],$download,$userApplayRealAuthNumber);
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
    public function addUser($validated,$admin)
    {
        $result = code(config('admin_code.AddUserError'));

        $user = new User;

        $user->phone = $validated['phone'];

        $user->password = Hash::make($validated['password']);

        //用户级别 默认最低
        $user->level_id = 1;
        //用户默认未认证
        $user->real_auth_status = 10;
        //用户默认是可用的
        $user->switch = 1;
        //创建张账户
        $user->account_name = \bin2hex(\random_bytes(4));
        //创建认证token
        $user->auth_token = Str::random(20);
         // 推荐人id
        if(checkId($validated['source_id']) && $validated['source_id'] > 0)
        {
            $user->source_id = $validated['source_id'];
        }

        $user->created_at = time();
        $user->created_time = time();

        //保存用户
        $userResult = $user->save();

        // 邀请码
        $user_id = $user->id;

        if(mb_strlen($user_id) < 4)
        {
            $user->invite_code = str_pad($user_id,4,'0',STR_PAD_LEFT);
        }
        else
        {
             $user->invite_code = $user_id;
        }

        $userResult = $user->save();

        if(!$userResult)
        {
            throw new CommonException('AddUserError');
        }

        AddUserEvent::dispatch($user,$admin,$validated);

        $eventResult = CommonEvent::dispatch($admin,$validated,'AddUser');


        $result = code(['code'=>0,'msg'=>'添加用户成功!']);


        return $result;
    }


    /**
     * 禁用用户
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function disableUser($validated,$admin)
    {
        $result = code(config('admin_code.DisableUserError'));

        $checkResult = $this->checkIsSystemUserByUserId($validated['id']);

        if($checkResult)
        {
            throw new CommonException('DisableSystemUserError');
        }

        $user = User::find($validated['id']);

        $revision = $user->revision;

        $updateData = ['switch'=>$validated['switch'],'updated_time'=>time(),'updated_at'=>\date('Y-m-d H:i:s',time()),'revision'=>$revision + 1];

        $userResult = User::where('id',$validated['id'])->where('revision',$revision)->update($updateData);

        if(!$userResult)
        {
            throw new CommonException('DisableUserError');
        }

        CommonEvent::dispatch($admin,$validated,'DisableUser');

        $result = code(['code'=>0,'msg'=>'禁用用户成功!']);

        return $result;
    }



    /**
     * 批量禁用用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDisableUser($validated,$admin)
    {
        $result = code(config('admin_code.MultipleDisableUserError'));

        if(isset($validated['selectId']) && count($validated['selectId']))
        {
            $checkResult = $this->checkIsSystemUserByUserIdArray($validated['selectId']);

            if($checkResult)
            {
                throw new CommonException('MultipleDisableSystemUserError');
            }

            $updateData = ['switch'=>$validated['switch'],'updated_time'=>time(),'updated_at'=>\date('Y-m-d H:i:s',time())];

            $disableResult = User::whereIn('id',$validated['selectId'])->update($updateData);

            if(!$disableResult)
            {
                throw new CommonException('MultipleDisableUserError');
            }

            CommonEvent::dispatch($admin,$validated,'MultipleDisableUser');

            $result = code(['code'=>0,'msg'=>'批量禁用用户成功!']);
        }

        return $result;
    }

    /**
     * 删除用户
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function deleteUser( $validated,$admin)
    {
        $result = code(config('admin_code.DeleteUserError'));

        $checkResult = $this->checkIsSystemUserByUserId($validated['id']);

        if($checkResult)
        {
            throw new CommonException('DeleteSystemUserError');
        }

        $user = User::find($validated['id']);

        $user->deleted_time = time();

        $user->deleted_at = date('Y-m-d H:i:s',time());

        $userResult = $user->save();

        if(!$userResult)
        {
            throw new CommonException('DeleteUserError');
        }

        CommonEvent::dispatch($admin, $validated,'DeleteUser');

        $result = code(['code'=>0,'msg'=>'删除用户成功!']);

        return $result;
    }

    /**
     * 批量删除用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDeleteUser($validated,$admin)
    {
        $result = code(config('admin_code.MultipleDeleteUserError'));

        if(isset($validated['selectId']) && count($validated['selectId']))
        {
            $checkResult = $this->checkIsSystemUserByUserIdArray($validated['selectId']);

            if($checkResult)
            {

                throw new CommonException('MultipleDeleteSystemUserError');
            }

            $deleteResult = User::whereIn('id',$validated['selectId'])->delete();

            if(!$deleteResult)
            {
                throw new CommonException('MultipleDeleteUserError');
            }

            CommonEvent::dispatch($admin,$validated,'MultipleDeleteUser');

            $result = code(['code'=>0,'msg'=>'批量删除用户成功!']);
        }

        return $result;
    }

    /**
     * 通过用户id检测是否是系统用户
     *
     * @param  [type] $user_id
     */
    protected function checkIsSystemUserByUserId($user_id = 0)
    {

        $checkResult = 0;

        if($user_id == 1 || $user_id == 2 || $user_id == 3 || $user_id == 4)
        {
            $checkResult = 1;
        }

        return $checkResult;
    }

    /**
     * 通过用户id数组检测是否含有系统和用户
     *
     * @param  array $user_id_array
     */
    protected function checkIsSystemUserByUserIdArray($user_id_array = [])
    {
        $checkResult = 0;

        if(in_array(1,$user_id_array) || in_array(2,$user_id_array) || in_array(3,$user_id_array) || in_array(4,$user_id_array))
        {
             $checkResult = 1;
        }

         return $checkResult;
    }
}
