<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-17 03:09:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 03:09:58
 * @FilePath: \app\Facade\Common\Total\TotalAllDataFacade.php
 */

namespace App\Facade\Common\Total;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Common\Total\TotalAllDataFacadeService
 */
class TotalAllDataFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "TotalAllDataFacade";
    }
}
