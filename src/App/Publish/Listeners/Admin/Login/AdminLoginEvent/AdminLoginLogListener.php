<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 14:36:09
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 15:21:18
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Listeners\Admin\Login\AdminLoginEvent\AdminLoginLogListener.php
 */

namespace App\Listeners\Admin\Login\AdminLoginEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Exceptions\Admin\CommonException;

use App\Models\Admin\Log\AdminLoginLog;

/**
 * @see \App\Events\Admin\Login\AdminLoginEvent
 */
class AdminLoginLogListener
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
        $validated= $event->validated;

        $adminLoginLog = new AdminLoginLog;

        $data = ['admin_id'=>$admin->id,'status'=>10,'instruction'=>'管理员登录','ip'=>$validated['ip'],'created_at'=>time(),'created_time'=>time()];

        foreach($data as $key => $value)
        {
            $adminLoginLog->$key = $value;
        }

        $result = $adminLoginLog->save();

        if(!$result)
        {
            throw new CommonException('AdminLoginLogError');
        }
    }
}
