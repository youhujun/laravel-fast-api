<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-31 23:22:53
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-31 23:23:02
 * @FilePath: \app\Facade\Admin\System\Region\AdminRegionFacade.php
 */

namespace App\Facade\Admin\System\Region;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\Region\AdminRegionFacadeService
 */
class AdminRegionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminRegionFacade";
    }
}
