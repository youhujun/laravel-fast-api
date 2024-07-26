<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 03:06:12
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 03:23:27
 * @FilePath: \app\Listeners\Admin\User\User\AddUserEvent\AddUserInfoListener.php
 */

namespace App\Listeners\Admin\User\User\AddUserEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\UserInfo;

/**
 * @see \App\Events\Admin\User\User\AddUserEvent
 */
class AddUserInfoListener
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
        $validated = $event->validated;

        //用户详情
        $userInfo = new UserInfo;

        $userInfo->nick_name = isset($validated['nick_name'])?$validated['nick_name']:'';
        $userInfo->sex = isset($validated['sex'])?$validated['sex']:0;

        $userInfo->created_at = time();
        $userInfo->created_time = time();

        $userInfo->user_id = $user->id;

        $userInfoResult = $userInfo ->save();

        if(!$userInfoResult)
        {
            throw new CommonException('AddUserInfoError');
        }
    }
}
