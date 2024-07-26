<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-17 03:09:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 03:16:55
 * @FilePath: \app\Service\Facade\Common\Total\TotalAllDataFacadeService.php
 */

namespace App\Service\Facade\Common\Total;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * @see \App\Facade\Common\Total\TotalAllDataFacade
 */
class TotalAllDataFacadeService
{
   public function test()
   {
       echo "TotalAllDataFacadeService test";
   }

   /**
    * 执行所有统计
    */
   public function doAllTotal()
   {
        Log::debug(['AllTotal'=>'执行所有统计']);
   }
}
