<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 23:43:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-14 23:54:28
 * @FilePath: \app\Facade\Admin\System\SystemConfig\AdminSystemConfigFacade.php
 */

namespace App\Facade\Admin\System\SystemConfig;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\SystemConfig\AdminSystemConfigFacadeService
 */
class AdminSystemConfigFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminSystemConfigFacade";
    }
}
