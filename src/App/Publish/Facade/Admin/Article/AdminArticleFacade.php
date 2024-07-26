<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 00:13:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 00:15:03
 * @FilePath: \app\Facade\Admin\Article\AdminArticleFacade.php
 */

namespace App\Facade\Admin\Article;

use Illuminate\Support\Facades\Facade;

/***
 * @see \App\Service\Facade\Admin\Article\AdminArticleFacadeService
 */
class AdminArticleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminArticleFacade";
    }
}
