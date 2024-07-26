<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-16 18:51:10
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-16 18:51:25
 * @FilePath: \app\Facade\Phone\Websocket\User\PhoneSocketUserFacade.php
 */

namespace App\Facade\Phone\Websocket\User;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Phone\Websocket\User\PhoneSocketUserFacadeService
 */
class PhoneSocketUserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PhoneSocketUserFacade";
    }
}
