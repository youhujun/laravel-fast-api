<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-09 19:48:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 09:34:08
 * @FilePath: \app\Facade\Admin\User\User\AdminUserDetailsFacade.php
 */

namespace App\Facade\Admin\User\User;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\User\User\AdminUserDetailsFacadeService
 */
class AdminUserDetailsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminUserDetailsFacade";
    }
}
