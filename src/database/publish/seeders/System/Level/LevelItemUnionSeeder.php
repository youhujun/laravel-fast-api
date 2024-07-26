<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-03-28 15:41:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-06 21:15:58
 * @FilePath: \api.laravel.com_LV9\database\seeders\System\Level\LevelItemUnionSeeder.php
 */

namespace Database\Seeders\System\Level;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelItemUnionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userLevelItemUnionData = [
            //1
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'user_level_id'=>1,'level_item_id'=>1,'value'=>0,'value_type'=>40],
            //2
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'user_level_id'=>2,'level_item_id'=>1,'value'=>100,'value_type'=>40],
            //3
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'user_level_id'=>3,'level_item_id'=>1,'value'=>600,'value_type'=>40],
            //4
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'user_level_id'=>4,'level_item_id'=>1,'value'=>1800,'value_type'=>40],
            //5
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'user_level_id'=>5,'level_item_id'=>1,'value'=>7200,'value_type'=>40],
            //6
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'user_level_id'=>6,'level_item_id'=>1,'value'=>16000,'value_type'=>40],
        ];

        DB::table('user_level_item_union')->insert($userLevelItemUnionData);

    }
}
