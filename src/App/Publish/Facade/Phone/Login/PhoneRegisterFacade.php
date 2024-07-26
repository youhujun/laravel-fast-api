<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-01 09:58:00
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-01 09:58:05
 * @FilePath: \app\Facade\Phone\Login\PhoneRegisterFacade.php
 */

namespace App\Facade\Phone\Login;

use Illuminate\Support\Facades\Facade;

/**
 *  @see \App\Service\Facade\Phone\Login\PhoneRegisterFacadeService
 */
class PhoneRegisterFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PhoneRegisterFacade";
    }
}
