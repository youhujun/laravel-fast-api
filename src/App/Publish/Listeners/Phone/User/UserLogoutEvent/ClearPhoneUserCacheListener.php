<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-10 09:49:34
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-10 09:49:40
 * @FilePath: \app\Listeners\Phone\User\UserLogoutEvent\ClearPhoneUserCacheListener.php
 */

namespace App\Listeners\Phone\User\UserLogoutEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\Phone\CommonException;

/**
 * @see \App\Events\Phone\User\UserLogoutEvent
 */
class ClearPhoneUserCacheListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {

       $token = $event->token;
       $user = $event->user;

       Redis::del("phone_user_token:{$token}");
       Redis::hdel("phone_user:user",$user->id);
       Redis::hdel("phone_user_info:user_info",$user->id);
    }
}
