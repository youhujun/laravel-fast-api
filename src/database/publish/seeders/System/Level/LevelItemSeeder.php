<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-03-28 13:54:53
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-06 21:05:10
 * @FilePath: \api.laravel.com_LV9\database\seeders\System\Level\LevelItemSeeder.php
 */

namespace Database\Seeders\System\Level;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levelItemData = [
            //1
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'type'=>10,'item_name'=>'用户积分','item_code'=>'user_score','description'=>'用户积分项']
        ];

        DB::table('level_item')->insert($levelItemData);
    }
}
