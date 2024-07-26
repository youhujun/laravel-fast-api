<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-01 20:57:04
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-03 08:00:58
 * @FilePath: \app\Listeners\Phone\User\UserRegisterEvent\AddUserRoleListener.php
 */

namespace App\Listeners\Phone\User\UserRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use App\Exceptions\phone\CommonException;
use Illuminate\Support\Facades\Log;

use App\Models\User\Union\UserRoleUnion;

class AddUserRoleListener
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
        $isTransation = $event->isTransation;

        $data = [];
        $date = date('Y-m-d H:i:s',time());
        $time = time();
        $user_id = $user->id;

        $data[0] = ['created_at' =>$date,'created_time'=>$time,'user_id'=>$user_id,'role_id'=>4];

        $userRoleUnionResult = UserRoleUnion::insert($data);

        if(!$userRoleUnionResult)
        {
            if($isTransation)
            {
                DB::rollBack();
            }
            throw new CommonException('AddUserRoleError');
        }
    }
}
