<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 13:12:32
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 13:12:36
 * @FilePath: \app\Facade\Public\Wechat\Pay\WechatJsPayDecryptFacade.php
 */

namespace App\Facade\Public\Wechat\Pay;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Public\Wechat\Pay\WechatJsPayDecryptFacadeService
 */
class WechatJsPayDecryptFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "WechatJsPayDecryptFacade";
    }
}
