<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 20:03:22
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 04:59:08
 * @FilePath: \app\Listeners\Admin\CommonEvent\CommonEventListener.php
 */

namespace App\Listeners\Admin\CommonEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

use App\Exceptions\Admin\CommonException;

use App\Models\Admin\Log\AdminEventLog;

use Illuminate\Support\Facades\Route;
/**
 * @see \App\Events\Admin\CommonEvent
 */
class CommonEventListener
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

        $logData = $event->logData;

        $eventCode = $event->eventCode;

        $isTransation = $event->isTransation;

        $adminEventLog = new AdminEventLog;

        $adminEventLog->admin_id = $admin->id;
        $adminEventLog->event_route_action = Route::currentRouteAction();

        $adminEventLog->event_name = \config("admin_event.{$eventCode}.info");;

        $adminEventLog->event_type = \config("admin_event.{$eventCode}.code");

        $adminEventLog->event_code = \config("admin_event.{$eventCode}.event");

        if($logData)
        {
             $adminEventLog->remark_data = \json_encode($logData);
        }
        else
        {
            $adminEventLog->remark_data = \json_encode($admin);
        }

        $adminEventLog->created_time = time();
        $adminEventLog->created_at = time();

        $result = $adminEventLog->save();

        if(!$result)
        {
            if($isTransation)
            {
                DB::rollBack();
            }

            throw new CommonException("{$eventCode}EventError");
        }

    }
}
