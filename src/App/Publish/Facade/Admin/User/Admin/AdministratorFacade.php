<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-04 00:23:42
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 00:28:43
 * @FilePath: \app\Facade\Admin\User\Admin\AdministratorFacade.php
 */

namespace App\Facade\Admin\User\Admin;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\User\Admin\AdministratorFacadeService
 */
class AdministratorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdministratorFacade";
    }
}
