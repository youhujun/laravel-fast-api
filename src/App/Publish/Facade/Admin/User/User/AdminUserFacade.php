<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 14:58:02
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 14:58:13
 * @FilePath: \app\Facade\Admin\User\User\AdminUserFacade.php
 */

namespace App\Facade\Admin\User\User;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\User\User\AdminUserFacadeService
 */
class AdminUserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminUserFacade";
    }
}
