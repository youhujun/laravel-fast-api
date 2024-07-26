<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-19 10:23:21
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 10:23:58
 * @FilePath: \app\Facade\Admin\System\SystemConfig\AdminVoiceConfigFacade.php
 */

namespace App\Facade\Admin\System\SystemConfig;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\SystemConfig\AdminVoiceConfigFacadeService
 */
class AdminVoiceConfigFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminVoiceConfigFacade";
    }
}
