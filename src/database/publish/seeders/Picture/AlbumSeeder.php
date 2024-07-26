<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-07-24 14:49:06
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 04:31:03
 * @FilePath: \database\seeders\Picture\AlbumSeeder.php
 */

namespace Database\Seeders\Picture;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $albumData = [
            ['admin_id'=>0,'user_id'=>0,'album_name'=>'config','is_default'=>1,'is_system'=>1,'album_description'=>'系统默认相册','sort'=>100,'album_type'=>0,'cover_album_picture_id'=>1,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],

            ['admin_id'=>1,'user_id'=>0,'album_name'=>'admin_develop','is_default'=>1,'is_system'=>1,'album_description'=>'admin_develop','sort'=>100,'album_type'=>10,'cover_album_picture_id'=>1,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['admin_id'=>2,'user_id'=>0,'album_name'=>'admin_super','is_default'=>1,'is_system'=>1,'album_description'=>'admin_super','sort'=>100,'album_type'=>10,'cover_album_picture_id'=>1,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['admin_id'=>3,'user_id'=>0,'album_name'=>'admin_admin','is_default'=>1,'is_system'=>1,'album_description'=>'admin_admin','sort'=>100,'album_type'=>10,'cover_album_picture_id'=>1,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],

            ['admin_id'=>0,'user_id'=>1,'album_name'=>'user_develop','is_default'=>1,'is_system'=>1,'album_description'=>'user_develop','sort'=>100,'album_type'=>20,'cover_album_picture_id'=>1,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['admin_id'=>0,'user_id'=>2,'album_name'=>'user_super','is_default'=>1,'is_system'=>1,'album_description'=>'user_super','sort'=>100,'album_type'=>20,'cover_album_picture_id'=>1,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['admin_id'=>0,'user_id'=>3,'album_name'=>'user_admin','is_default'=>1,'is_system'=>1,'album_description'=>'user_admin','sort'=>100,'album_type'=>20,'cover_album_picture_id'=>1,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
            ['admin_id'=>0,'user_id'=>4,'album_name'=>'user_user','is_default'=>1,'is_system'=>1,'album_description'=>'user_user','sort'=>100,'album_type'=>20,'cover_album_picture_id'=>1,'created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())]
        ];
        DB::table('album')->insert($albumData);
    }
}
