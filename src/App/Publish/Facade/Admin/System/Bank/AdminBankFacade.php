<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-31 23:31:19
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-31 23:31:24
 * @FilePath: \app\Facade\Admin\System\Bank\AdminBankFacade.php
 */

namespace App\Facade\Admin\System\Bank;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\Bank\AdminBankFacadeService
 */
class AdminBankFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminBankFacade";
    }
}
