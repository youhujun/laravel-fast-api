<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-15 10:07:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-15 11:00:42
 * @FilePath: \app\Service\Facade\Phone\User\User\PhoneUserConfigFacadeService.php
 */

namespace App\Service\Facade\Phone\User\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Exceptions\Phone\CommonException;
use App\Events\Phone\CommonEvent;


/**
 * @see \App\Facade\Phone\User\User\PhoneUserConfigFacade
 */
class PhoneUserConfigFacadeService
{
   public function test()
   {
       echo "PhoneUserConfigFacadeService test";
   }

   /**
    * 清理用户缓存
    *
    * @param  [type] $user
    */
   public function clearUserCache($user)
   {
        $result = code(config('phone_code.ClearUserCacheError'));

        Redis::hdel("phone_user_info:user_info",$user->id);

        CommonEvent::dispatch($user,[],'ClearUserCache');

        $result = code(['code'=> 0,'msg'=>'清理用户缓存成功!']);

        return $result;
   }
}
