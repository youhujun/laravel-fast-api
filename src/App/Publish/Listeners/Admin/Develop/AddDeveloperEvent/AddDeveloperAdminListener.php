<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 08:09:43
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-22 16:46:39
 * @FilePath: \app\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperAdminListener.php
 */

namespace App\Listeners\Admin\Develop\AddDeveloperEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Admin\Admin;
/**
 * @see  \App\Events\Admin\Develop\AddDeveloperEvent
 */
class AddDeveloperAdminListener
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
        $admin = $event->admin;
        $user = $event->user;
        $validated = $event->validated;

        $admin = new Admin;

        $admin->user_id = $user->id;
        $admin->account_name = $user->account_name;
        $admin->password = $user->password;
        //默认是可用的
        $admin->switch = 1;
        $admin->created_at = time();
        $admin->created_time = time();

        $result = $admin->save();

        if(!$result)
        {
            throw new CommonException('AddDevelopAdminError');
        }

    }
}
