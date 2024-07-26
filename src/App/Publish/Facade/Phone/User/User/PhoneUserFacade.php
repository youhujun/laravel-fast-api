<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 17:40:24
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 17:40:30
 * @FilePath: \app\Facade\Phone\User\User\PhoneUserFacade.php
 */

namespace App\Facade\Phone\User\User;

use Illuminate\Support\Facades\Facade;

class PhoneUserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PhoneUserFacade";
    }
}
