<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 11:09:29
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 11:12:19
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Facade\Admin\Login\AdminLoginFacade.php
 */

namespace App\Facade\Admin\Login;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\Login\AdminLoginFacadeService
 */
class AdminLoginFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminLoginFacade";
    }
}
