<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 22:27:34
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 22:27:50
 * @FilePath: \app\Facade\Admin\System\Platform\PhoneBanner\AdminPhoneBannerDetailsFacade.php
 */

namespace App\Facade\Admin\System\Platform\PhoneBanner;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Service\Facade\Admin\System\Platform\PhoneBanner\AdminPhoneBannerDetailsFacadeService
 */
class AdminPhoneBannerDetailsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "AdminPhoneBannerDetailsFacade";
    }
}
