<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-01-06 12:36:10
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-03-01 16:55:33
 * @FilePath: \base.laravel.comd:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\src\database\seeders\System\RoleSeeder.php
 */

namespace Database\Seeders\System;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleData = [
            //1
            ['role_name'=>'开发者','logic_name'=>'develop','parent_id'=>0,'switch'=>1,'created_time'=>time(),'deep'=>1],
            //2
            ['role_name'=>'超级管理员','logic_name'=>'super','parent_id'=>0,'switch'=>1,'created_time'=>time(),'deep'=>1],
            //3
            ['role_name'=>'管理员','logic_name'=>'admin','parent_id'=>0,'switch'=>1,'created_time'=>time(),'deep'=>1],
            //4
            ['role_name'=>'用户','logic_name'=>'user','parent_id'=>0,'switch'=>1,'created_time'=>time(),'deep'=>1],
        ];
        DB::table('role')->insert($roleData);
    }
}
