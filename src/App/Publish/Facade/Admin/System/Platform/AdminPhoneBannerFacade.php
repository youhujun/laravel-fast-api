<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 19:45:19
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 19:47:13
 * @FilePath: \app\Facade\Admin\System\Platform\AdminPhoneBannerFacade.php
 */

namespace App\Facade\Admin\System\Platform;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\Platform\AdminPhoneBannerFacadeService
 */
class AdminPhoneBannerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminPhoneBannerFacade";
    }
}
