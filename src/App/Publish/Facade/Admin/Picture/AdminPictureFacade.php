<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 02:59:54
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 03:00:27
 * @FilePath: \app\Facade\Admin\Picture\AdminPictureFacade.php
 */

namespace App\Facade\Admin\Picture;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\Picture\AdminPictureFacadeService
 */
class AdminPictureFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminPictureFacade";
    }
}
