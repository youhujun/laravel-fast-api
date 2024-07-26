<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 23:00:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 23:06:34
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Listeners\Admin\Login\AdminLogoutEvent\AdminLogoutLogLitener.php
 */

namespace App\Listeners\Admin\Login\AdminLogoutEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Exceptions\Admin\CommonException;

use App\Models\Admin\Log\AdminLoginLog;

/**
 * @see \App\Events\Admin\Login\AdminLogoutEvent
 */
class AdminLogoutLogLitener
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
        $ip= $event->ip;

        $adminLoginLog = new AdminLoginLog;

        $data = ['admin_id'=>$admin->id,'status'=>20,'instruction'=>'管理员退出','ip'=>$ip,'created_at'=>time(),'created_time'=>time()];

        foreach($data as $key => $value)
        {
            $adminLoginLog->$key = $value;
        }

        $result = $adminLoginLog->save();

        if(!$result)
        {
            throw new CommonException('AdminLogoutLogError');
        }
    }
}
