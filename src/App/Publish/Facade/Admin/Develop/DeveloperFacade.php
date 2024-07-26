<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 07:43:38
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 07:48:29
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Facade\Admin\Develop\DeveloperFacade.php
 */

namespace App\Facade\Admin\Develop;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\Develop\DeveloperFacadeService
 */
class DeveloperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "DeveloperFacade";
    }
}
