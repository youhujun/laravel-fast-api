<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-09 19:43:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-21 17:01:19
 * @FilePath: \app\Service\Facade\Admin\User\User\AdminUserItemFacadeService.php
 */

namespace App\Service\Facade\Admin\User\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\User\User;

use App\Service\Facade\Trait\QueryService;

use App\Http\Resources\User\UserCollection;

/**
 * @see \App\Service\Facade\Admin\User\User\AdminUserItemFacadeService
 */
class AdminUserItemFacadeService
{
   public function test()
   {
       echo "AdminUserItemFacadeService test";
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
     * 获取默认的用户选项
     *
     * @return void
     */
    public function getDefaultUser($validated,$user)
    {

        $result = code(config('admin_code.GetDefaultUserError'));

        //先处理关联
        $this->withWhere = ['userInfo'];

        $query = User::with($this->withWhere);

        $this->where[] = ['switch','=',1];

        //如果要求实名认证状态
        if(isset($validated['real_auth_status']))
        {
             $this->where[] = ['real_auth_status','=',$validated['real_auth_status']];
        }

        $query->where($this->where);

        $query->orderBy(self::$sort[2][0],self::$sort[2][1]);

        $collection =  $query->limit(100)->get();

        $result = new UserCollection($collection,['code'=>0,'msg'=>'获取默认用户选项成功!']);

        return $result;
    }

    /**
     * 查找用户
     *
     * @param [type] $find
     * @return void
     */
    public function findUser($validated,$user)
    {
        $result = code(config('admin_code.FindUserError'));

        //判断是否是手机号
        $numberRegex = '/^[0-9]+$/';

        $numberResult = \preg_match($numberRegex,$validated['find']);

        $this->withWhere = ['userInfo'];

        $query = User::with($this->withWhere);

        $this->where[] = ['switch','=',1];

        if(isset($validated['real_auth_status']))
        {
             $this->where[] = ['real_auth_status','=',$validated['real_auth_status']];
        }

        $query->where($this->where);

        //如果是手机号
        if($numberResult)
        {
            $userWhere[] = ['phone','like',"%{$validated['find']}%"];

            $query->where($userWhere);
        }
        else
        {
            $where[] = ['real_name','like',"%{$validated['find']}%"];
            $orWhere[] = ['nick_name','like',"%{$validated['find']}%"];

            $query->whereHas('userInfo',function(Builder $withQuery)use($where, $orWhere){
                    $withQuery->where($where)->orWhere( $orWhere);});
        }

        $query->orderBy(self::$sort[2][0],self::$sort[2][1]);

        $collection =  $query->limit(100)->get();

        $result = new UserCollection($collection,['code'=>0,'msg'=>'查找用户选项成功!']);

        return $result;
    }
}
