<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-16 10:50:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-16 10:50:25
 * @FilePath: \app\Facade\Phone\Websocket\PhoneSocketFacade.php
 */

namespace App\Facade\Phone\Websocket;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Phone\Websocket\PhoneSocketFacadeService
 */
class PhoneSocketFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PhoneSocketFacade";
    }
}
