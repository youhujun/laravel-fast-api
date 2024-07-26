<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 02:54:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 02:54:51
 * @FilePath: \app\Facade\Admin\Picture\AdminAlbumFacade.php
 */

namespace App\Facade\Admin\Picture;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\Picture\AdminAlbumFacadeService
 */
class AdminAlbumFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminAlbumFacade";
    }
}
