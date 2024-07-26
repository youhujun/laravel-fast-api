<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-28 18:22:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-28 18:23:51
 * @FilePath: \app\Facade\Public\Sms\TencentSmsFacade.php
 */

namespace App\Facade\Public\Sms;

use Illuminate\Support\Facades\Facade;

/**
 * @see  \App\Service\Facade\Public\Sms\TencentSmsFacadeService
 */
class TencentSmsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "TencentSmsFacade";
    }
}
