<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-01-06 12:36:10
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-03-01 17:03:06
 * @FilePath: \base.laravel.comd:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\src\database\seeders\System\Group\Category\CategorySeeder.php
 */

namespace Database\Seeders\System\Group\Category;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'parent_id'=>0,'deep'=>1,'category_name'=>'公告通知'],
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'parent_id'=>1,'deep'=>2,'category_name'=>'内部通知'],
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'parent_id'=>1,'deep'=>2,'category_name'=>'外部公告'],
            ['created_at'=>\date('Y-m-d H:i:s',time()),'created_time'=>time(),'sort'=>100,'parent_id'=>0,'deep'=>1,'category_name'=>'系统文章']
        ];

        DB::table('category')->insert($data);
    }
}
