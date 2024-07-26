<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-09 19:49:00
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 00:27:58
 * @FilePath: \app\Facade\Admin\User\User\AdminUserTeamFacade.php
 */

namespace App\Facade\Admin\User\User;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\User\User\AdminUserTeamFacadeService
 */
class AdminUserTeamFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminUserTeamFacade";
    }
}
