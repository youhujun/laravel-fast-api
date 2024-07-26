<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-01 11:07:42
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 11:10:55
 * @FilePath: \app\Facade\Public\Excel\PublicExcelFacade.php
 */

namespace App\Facade\Public\Excel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Public\Excel\PublicExcelFacadeService
 */
class PublicExcelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PublicExcelFacade";
    }
}
