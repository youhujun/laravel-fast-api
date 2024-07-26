<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-08 14:46:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 17:27:49
 * @FilePath: \app\Listeners\Phone\User\Wechat\WechatOfficialBindUserOpenidEvent\WechatOfficialBindUserOpenidListener.php
 */

namespace App\Listeners\Phone\User\Wechat\WechatOfficialBindUserOpenidEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Phone\CommonException;

use App\Models\User\UserWechat;

/**
 * @see \App\Events\Phone\User\Wechat\WechatOfficialBindUserOpenidEvent
 */
class WechatOfficialBindUserOpenidListener
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

        $openid = '';
        $wechat_official_appid = '';

        if(isset($params['openid']))
        {
            $openid = $params['openid'];
        }

        if(isset($params['wechat_official_appid']))
        {
             $wechat_official_appid = $params['wechat_official_appid'];
        }

        $userWechat = UserWechat::where('user_id',$user->id)->first();

        if(!$userWechat)
        {
            $userWechat = new UserWechat;

            $userWechat->wechat_verified_at = date('Y-m-d H:i:s',time());

            $userWechat->wechat_verified_time = time();

            $userWechat->created_at = time();
            $userWechat->created_time = time();

            $userWechat->user_id = $user->id;
            $userWechat->openid = $openid;

            $userWechat->wechat_official_appid = $wechat_official_appid;

            $userWechatResult = $userWechat->save();

            if(!$userWechatResult)
            {
                if($isTransation)
                {
                    DB::rollBack();
                }
                throw new CommonException('WehcatOfficialBindUserOpenidError');
            }
        }
        else
        {
            $openidWechat = UserWechat::where('openid',$openid)->first();

            if(!$openidWechat)
            {
                $userWechat->openid = $openid;

                $userWechat->wechat_official_appid = $wechat_official_appid;

                $userWechat->updated_at = time();
                $userWechat->updated_time = time();

                $userWechatResult = $userWechat->save();

                if(!$userWechatResult)
                {
                    if($isTransation)
                    {
                        DB::rollBack();
                    }
                    throw new CommonException('WehcatOfficialBindUserOpenidError');
                }
            }
            else
            {
                if($openidWechat->user_id !== $userWechat->user_id)
                {
                    throw new CommonException('WehcatOfficialBindUserOpenidDoubleUserError');
                }
            }

        }
    }
}
