<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-15 10:07:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-15 10:07:31
 * @FilePath: \app\Facade\Phone\User\User\PhoneUserConfigFacade.php
 */

namespace App\Facade\Phone\User\User;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Phone\User\User\PhoneUserConfigFacadeService
 */
class PhoneUserConfigFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PhoneUserConfigFacade";
    }
}
