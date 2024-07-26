<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-08 12:42:56
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 13:34:12
 * @FilePath: \app\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserRoleListener.php
 */

namespace App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use App\Exceptions\phone\CommonException;
use Illuminate\Support\Facades\Log;

use App\Models\User\Union\UserRoleUnion;

/**
 *@see \App\Events\Phone\User\Wechat\WechatOfficialRegisterEvent
 */
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

            throw new CommonException('WechatOfficialAddUserRoleError');
        }
    }
}
