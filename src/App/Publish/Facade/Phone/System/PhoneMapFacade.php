<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 16:16:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 16:16:45
 * @FilePath: \app\Facade\Phone\System\PhoneMapFacade.php
 */

namespace App\Facade\Phone\System;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Phone\System\PhoneMapFacadeService
 */
class PhoneMapFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PhoneMapFacade";
    }
}
