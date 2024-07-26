<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 10:46:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 10:46:50
 * @FilePath: \app\Facade\Admin\System\Group\AdminLabelFacade.php
 */

namespace App\Facade\Admin\System\Group;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\Group\AdminLabelFacadeService
 */
class AdminLabelFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminLabelFacade";
    }
}
