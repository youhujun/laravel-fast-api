<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-09 19:43:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-09 19:44:03
 * @FilePath: \app\Facade\Admin\User\User\AdminUserItemFacade.php
 */

namespace App\Facade\Admin\User\User;

use Illuminate\Support\Facades\Facade;

/**
 * @see  \App\Service\Facade\Admin\User\User\AdminUserItemFacadeService
 */
class AdminUserItemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminUserItemFacade";
    }
}
