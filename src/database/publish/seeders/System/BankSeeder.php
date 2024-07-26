<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-02-14 18:18:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-06 21:27:46
 * @FilePath: \api.laravel.com_LV9\database\seeders\System\BankSeeder.php
 */


namespace Database\Seeders\System;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $bankData = [
            ['bank_name'=>'中国银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['bank_name'=>'农业银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['bank_name'=>'工商银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['bank_name'=>'建设银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],

           /*  ['bank_name'=>'招商银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['bank_name'=>'浦发银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['bank_name'=>'广发银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['bank_name'=>'华夏银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['bank_name'=>'民生银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['bank_name'=>'交通银行','is_default'=>1,'sort'=>100,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())] */

        ];
        DB::table('bank')->insert($bankData);
    }
}
