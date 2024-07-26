<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-09 19:48:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 00:25:02
 * @FilePath: \app\Facade\Admin\User\User\AdminUserAddressFacade.php
 */

namespace App\Facade\Admin\User\User;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\User\User\AdminUserAddressFacadeService
 */
class AdminUserAddressFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminUserAddressFacade";
    }
}
