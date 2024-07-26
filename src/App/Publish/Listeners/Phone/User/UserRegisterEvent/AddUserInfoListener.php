<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-01 20:52:36
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-02 14:50:59
 * @FilePath: \app\Listeners\Phone\User\UserRegisterEvent\AddUserInfoListener.php
 */

namespace App\Listeners\Phone\User\UserRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Phone\CommonException;

use App\Models\User\UserInfo;

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

        $isTransation = $event->isTransation;

        //用户详情
        $userInfo = new UserInfo;

        //用户id
        $userInfo->user_id = $user->id;
        $userInfo->nick_name ='';
        $userInfo->real_name ='';
        $userInfo->id_number = null;
        $userInfo->solar_birthday_at = null;
        $userInfo->solar_birthday_time = 0;
        $userInfo->sex = 0;
        $userInfo->created_at = time();
        $userInfo->created_time = time();

        $userInfoResult = $userInfo ->save();

        if(!$userInfoResult)
        {
            if($isTransation)
            {
                 DB::rollBack();
            }

            throw new CommonException('AddUserInfoError');
        }
    }
}
