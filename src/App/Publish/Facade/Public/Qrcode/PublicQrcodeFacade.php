<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 20:33:33
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 20:34:12
 * @FilePath: \app\Facade\Public\Qrcode\PublicQrcodeFacade.php
 */

namespace App\Facade\Public\Qrcode;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Public\Qrcode\PublicQrcodeFacadeService
 */
class PublicQrcodeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "PublicQrcodeFacade";
    }
}
