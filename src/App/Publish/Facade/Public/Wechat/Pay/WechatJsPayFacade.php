<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 09:52:28
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 09:53:58
 * @FilePath: \app\Facade\Public\Wechat\Pay\WechatJsPayFacade.php
 */

namespace App\Facade\Public\Wechat\Pay;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Public\Wechat\Pay\WechatJsPayFacadeService
 */
class WechatJsPayFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "WechatJsPayFacade";
    }
}
