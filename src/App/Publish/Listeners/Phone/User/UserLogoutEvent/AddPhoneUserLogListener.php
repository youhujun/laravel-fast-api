<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-10 09:40:04
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-10 09:46:05
 * @FilePath: \app\Listeners\Phone\User\UserLogoutEvent\AddPhoneUserLogListener.php
 */

namespace App\Listeners\Phone\User\UserLogoutEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Phone\CommonException;

use App\Models\User\Log\UserLoginLog;

/**
 * @see \App\Events\Phone\User\UserLogoutEvent
 */
class AddPhoneUserLogListener
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
        $user = $event->user;
        $ip = $event->ip;
        $isTransation = $event->isTransation;

        $userLoginLog = new UserLoginLog;

        $userLoginLog->user_id = $user->id;
        $userLoginLog->status = 20;
        $userLoginLog->ip = $ip;
        $userLoginLog->instruction = '用户退出';
        $userLoginLog->source_type = 10;
        $userLoginLog->created_at = time();
        $userLoginLog->created_time = time();

        $userLoginLogResult = $userLoginLog->save();

		if(!$userLoginLogResult)
		{
            if($isTransation)
            {
                DB::rollBack();
            }

			throw new CommonException('AddPhoneUserLoginLogError');
		}
    }
}
