<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-07-24 14:49:06
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 15:28:38
 * @FilePath: d:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\src\database\publish\seeders\System\Level\LevelSeeder.php
 */


namespace Database\Seeders\System\Level;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userLevelData = [
            //1
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'level_name'=>'游鹄客','level_code'=>'V0','amount'=>0,'background_id'=>0,'remark_info'=>''],
            //2
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'level_name'=>'游鹄卫','level_code'=>'V1','amount'=>0,'background_id'=>0,'remark_info'=>''],
            //3
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'level_name'=>'游鹄长','level_code'=>'V2','amount'=>0,'background_id'=>0,'remark_info'=>''],
            //4
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'level_name'=>'游鹄使','level_code'=>'V3','amount'=>0,'background_id'=>0,'remark_info'=>''],
            //5
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'level_name'=>'游鹄士','level_code'=>'V4','amount'=>0,'background_id'=>0,'remark_info'=>''],
            //6
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'level_name'=>'游鹄主','level_code'=>'V5','amount'=>0,'background_id'=>0,'remark_info'=>''],
        ];

        DB::table('user_level')->insert($userLevelData);

    }
}
