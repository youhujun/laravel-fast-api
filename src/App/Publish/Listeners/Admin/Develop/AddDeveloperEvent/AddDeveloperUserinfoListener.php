<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 08:11:58
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 21:47:06
 * @FilePath: \app\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserinfoListener.php
 */

namespace App\Listeners\Admin\Develop\AddDeveloperEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\UserInfo;
/**
 * @see \App\Events\Admin\Develop\AddDeveloperEvent
 */
class AddDeveloperUserinfoListener
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
        $admin = $event->admin;
        $validated = $event->validated;

        //用户详情
        $userInfo = new UserInfo;

        $userInfo->created_at = time();
        $userInfo->created_time = time();

        $userInfo->user_id = $user->id;
        $userInfo->nick_name = $validated['username'];

        $result = $userInfo ->save();

        if(!$result)
        {
            throw new CommonException('AddDeveloperInfoError');
        }
    }
}
