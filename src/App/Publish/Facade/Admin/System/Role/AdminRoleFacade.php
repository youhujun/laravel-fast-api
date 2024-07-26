<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-24 22:30:33
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-24 22:31:00
 * @FilePath: \app\Facade\Admin\System\Role\AdminRoleFacade.php
 */

namespace App\Facade\Admin\System\Role;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\Role\AdminRoleFacadeService
 */
class AdminRoleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminRoleFacade";
    }
}
