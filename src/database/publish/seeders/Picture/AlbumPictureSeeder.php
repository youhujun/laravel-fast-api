<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-24 18:30:12
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 20:59:56
 * @FilePath: \database\seeders\Picture\AlbumPictureSeeder.php
 */

namespace Database\Seeders\Picture;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlbumPictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $albumPictureData = [
            ['admin_id'=>1,'user_id'=>1,'album_id'=>1,'picture_name'=>'album','picture_path'=>DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'album'.DIRECTORY_SEPARATOR,'picture_file'=>'album.png','picture_size'=>'11','picture_spec'=>'80x80','picture_url'=>'https://qiniu.youhujun.com/config/album/album.png','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],

            ['admin_id'=>1,'user_id'=>1,'album_id'=>1,'picture_name'=>'avatar','picture_path'=>DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR,'picture_file'=>'avatar.gif','picture_size'=>'57','picture_spec'=>'658x494','picture_url'=>'https://qiniu.youhujun.com/config/avatar/avatar.gif','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time())],
        ];

        DB::table('album_picture')->insert($albumPictureData);

    }
}
