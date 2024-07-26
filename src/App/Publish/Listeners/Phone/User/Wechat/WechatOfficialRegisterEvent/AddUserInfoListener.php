<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-08 12:42:07
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 12:59:15
 * @FilePath: \app\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent\AddUserInfoListener.php
 */

namespace App\Listeners\Phone\User\Wechat\WechatOfficialRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Phone\CommonException;

use App\Models\User\UserInfo;


/**
 * @see \App\Events\Phone\User\Wechat\WechatOfficialRegisterEvent
 */
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
        $params = $event->params;
        $isTransation = $event->isTransation;

        $nick_name = '';

        if(isset($params['nick_name']))
        {
            $nick_name = $params['nick_name'];
        }

        $sex = 0;

        if(isset($params['sex']))
        {
            if($params['sex'] == 1)
            {
                $sex = 10;
            }

            if($params['sex'] == 2)
            {
                $sex = 20;
            }
        }

        //用户详情
        $userInfo = new UserInfo;



        //用户id
        $userInfo->user_id = $user->id;
        $userInfo->nick_name = $nick_name;
        $userInfo->real_name ='';
        $userInfo->id_number = null;
        $userInfo->solar_birthday_at = null;
        $userInfo->solar_birthday_time = 0;
        $userInfo->sex = $sex;
        $userInfo->created_at = time();
        $userInfo->created_time = time();

        $userInfoResult = $userInfo ->save();

        if(!$userInfoResult)
        {
            if($isTransation)
            {
                 DB::rollBack();
            }

            throw new CommonException('WechatOfficialAddUserInfoError');
        }

    }
}
