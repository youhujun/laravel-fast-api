<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-17 12:19:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 12:20:43
 * @FilePath: \app\Facade\Public\Store\QiNiuFacade.php
 */

namespace App\Facade\Public\Store;

use Illuminate\Support\Facades\Facade;

/**
 * @see  \App\Service\Facade\Public\Store\QiNiuFacadeService
 */
class QiNiuFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "QiNiuFacade";
    }
}
