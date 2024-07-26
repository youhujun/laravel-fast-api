<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 08:10:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 21:42:55
 * @FilePath: \app\Listeners\Admin\Develop\AddDeveloperEvent\AddDeveloperUserAddressListener.php
 */

namespace App\Listeners\Admin\Develop\AddDeveloperEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\UserAddress;
/**
 * @see \App\Events\Admin\Develop\AddDeveloperEvent
 */
class AddDeveloperUserAddressListener
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

         //用户地址
        $userAddress = new UserAddress;

        $userAddress->user_id = $user->id;
        $userAddress->created_at = time();
        $userAddress->created_time = time();
        $userAddress->is_default = 1;
        $userAddress->address_type = 10;

        $result =  $userAddress->save();

        if(!$result)
        {
            throw new CommonException('AddDeveloperAddressError');
        }
    }
}
