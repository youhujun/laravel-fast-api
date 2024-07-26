<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 22:32:30
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 22:32:53
 * @FilePath: \app\Facade\Admin\System\Level\AdminLevelItemFacade.php
 */

namespace App\Facade\Admin\System\Level;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\Level\AdminLevelItemFacadeService
 */
class AdminLevelItemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminLevelItemFacade";
    }
}
