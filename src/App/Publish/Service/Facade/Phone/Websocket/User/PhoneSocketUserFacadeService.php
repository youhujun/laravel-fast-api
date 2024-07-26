<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-16 18:51:10
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-16 19:48:17
 * @FilePath: \app\Service\Facade\Phone\Websocket\User\PhoneSocketUserFacadeService.php
 */

namespace App\Service\Facade\Phone\Websocket\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Models\User\User;

/**
 * @see \App\Facade\Phone\Websocket\User\PhoneSocketUserFacade
 */
class PhoneSocketUserFacadeService
{
   public function test()
   {
       echo "PhoneSocketUserFacadeService test";
   }


   /**
    * 检测socket 用户是否登录
    *
    * @param  [type] $user_id
    * @param  [type] $token
    */
   public function checkSocketUserIsLogin($user_id,$token)
   {
        $checkResult = 0;

        // og::debug(['$user_id'=>$user_id,'token'=>$token]);

        if(isset($user_id))
        {
            $user = User::find($user_id);

            // Log::debug(['$user'=>$user]);

            if($user->remember_token == $token)
            {
                $checkResult = 1;
                Log::debug(['$user_id'=>$user_id.'-socketLoginSuccess',]);
            }
        }

        return $checkResult;

   }

   /**
    * 保存socket用户
    *
    * @param  [type] $user_id
    * @param  [type] $frameId
    */
   public function saveSocketUser($user_id,$frameFd)
   {
        $result = 0;

        if(Redis::hget('socket:socket',$user_id))
        {
            Redis::hdel('socket:socket',$user_id);
        }

        $result = Redis::hset('socket:socket',$user_id,$frameFd);

        //Log::debug(['$redisResult'=>$user_id.'-'.$result,]);

        return $result;
   }

   /**
    * 删除socket用户
    *
    * @param  [type] $user_id
    */
   public function deleteSocketUser($user_id)
   {
        Redis::hdel('socket:socket',$user_id);
   }
}
