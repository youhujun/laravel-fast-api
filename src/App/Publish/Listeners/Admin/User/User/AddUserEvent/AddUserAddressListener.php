<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 03:06:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 04:14:47
 * @FilePath: \app\Listeners\Admin\User\User\AddUserEvent\AddUserAddressListener.php
 */

namespace App\Listeners\Admin\User\User\AddUserEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\UserAddress;

/**
 * @see \App\Events\Admin\User\User\AddUserEvent
 */
class AddUserAddressListener
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
        //
    }
}
