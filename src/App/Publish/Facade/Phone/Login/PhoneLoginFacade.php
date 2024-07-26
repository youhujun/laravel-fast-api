<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-27 10:40:52
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-27 10:40:59
 * @FilePath: \app\Facade\Phone\Login\PhoneLoginFacade.php
 */

namespace App\Facade\Phone\Login;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Phone\Login\PhoneLoginFacadeService
 */
class PhoneLoginFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PhoneLoginFacade";
    }
}
