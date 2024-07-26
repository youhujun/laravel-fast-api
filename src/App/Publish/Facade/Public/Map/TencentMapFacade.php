<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 14:53:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 14:54:09
 * @FilePath: \app\Facade\Public\Map\TencentMapFacade.php
 */

namespace App\Facade\Public\Map;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Public\Map\TencentMapFacadeService
 */
class TencentMapFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "TencentMapFacade";
    }
}
