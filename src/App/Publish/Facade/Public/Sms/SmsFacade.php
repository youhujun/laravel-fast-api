<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-28 18:18:00
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-28 18:19:58
 * @FilePath: \app\Facade\Public\Sms\SmsFacade.php
 */

namespace App\Facade\Public\Sms;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Public\Sms\SmsFacadeService
 */
class SmsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "SmsFacade";
    }
}
