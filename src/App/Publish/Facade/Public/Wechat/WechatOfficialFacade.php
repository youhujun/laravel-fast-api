<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-07 10:25:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-07 17:50:41
 * @FilePath: \app\Facade\Public\Wechat\WechatOfficialFacade.php
 */

namespace App\Facade\Public\Wechat;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Public\Wechat\WechatOfficialFacadeService
 */
class WechatOfficialFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "WechatOfficialFacade";
    }
}
