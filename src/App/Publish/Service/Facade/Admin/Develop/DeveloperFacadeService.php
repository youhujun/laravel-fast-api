<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 07:43:38
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 19:13:22
 * @FilePath: \app\Service\Facade\Admin\Develop\DeveloperFacadeService.php
 */

namespace App\Service\Facade\Admin\Develop;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Events\Admin\Develop\AddDeveloperEvent;

use App\Models\User\User;

/**
 * @see \App\Facade\Admin\Develop\DeveloperFacade
 */
class DeveloperFacadeService
{
   public function test()
   {
       echo "DeveloperFacadeService test";
   }

   /**
    * 添加开发者
    *
    * @param [type] $validated
    * @return void
    */
   public function addDeveloper($admin,$validated)
   {
       /*  Array
        (
            [username] => youhu
            [password] => abc123
        ) */

        $result = code(config('admin_code.AddDeveloperError'));

        $user = new User;

        $user->account_name = $validated['username'];

        $user->password = Hash::make($validated['password']);

        //用户级别 默认最低
        $user->level_id = 1;

        //用户默认未认证
        $user->real_auth_status = 10;
        //用户默认是可用的
        $user->switch = 1;
        //创建认证token
        $user->auth_token = Str::random(20);

        $user->created_at = time();
        $user->created_time = time();

        //保存用户
        $userResult = $user->save();

        $user_id = $user->id;

        $invite_code = $user_id;

        $length =  mb_strlen($invite_code);

        if($length < 4)
        {
            $invite_code = str_pad($invite_code,4,'0',STR_PAD_LEFT);
        }

        $user->invite_code = $invite_code;

        $userResult = $user->save();

        if(!$userResult)
        {
            throw new CommonException('AddDeveloperError');
        }

        AddDeveloperEvent::dispatch($admin,$user,$validated);

        CommonEvent::dispatch($admin,$validated,'AddDeveloper')[0];

        $result = code(['code'=>0,'msg'=>'添加开发者成功!']);

        return $result;

   }
}
