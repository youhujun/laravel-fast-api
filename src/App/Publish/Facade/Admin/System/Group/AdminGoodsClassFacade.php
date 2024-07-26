<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 10:42:07
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 10:42:52
 * @FilePath: \app\Facade\Admin\System\Group\AdminGoodsClassFacade.php
 */

namespace App\Facade\Admin\System\Group;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\Group\AdminGoodsClassFacadeService
 */
class AdminGoodsClassFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminGoodsClassFacade";
    }
}
