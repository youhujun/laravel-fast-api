<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 16:16:01
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 16:16:25
 * @FilePath: \app\Facade\Admin\Log\AdminLogFacade.php
 */

namespace App\Facade\Admin\Log;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\Log\AdminLogFacadeService
 */
class AdminLogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminLogFacade";
    }
}
