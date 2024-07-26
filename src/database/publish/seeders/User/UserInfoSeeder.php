<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-01-06 12:36:10
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 04:39:33
 * @FilePath: \database\seeders\User\UserInfoSeeder.php
 */


namespace Database\Seeders\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //添加用户头像信息
        $userAvatarData = [
            ['user_id'=>1,'album_picture_id'=>2,'is_default'=>1,'created_time'=>time()],
            ['user_id'=>2,'album_picture_id'=>2,'is_default'=>1,'created_time'=>time()],
            ['user_id'=>3,'album_picture_id'=>2,'is_default'=>1,'created_time'=>time()],
            ['user_id'=>4,'album_picture_id'=>2,'is_default'=>1,'created_time'=>time()]
        ];
        DB::table('user_avatar')->insert( $userAvatarData);

        //添加用户详情信息
        $userInfoData = [
            ['created_time'=>time(),'user_id'=>1,'nick_name'=>'developer','sex'=>0,'introduction'=>'I am a super developer'],
            ['created_time'=>time(),'user_id'=>2,'nick_name'=>'superAdmin','sex'=>10,'introduction'=>'I am a super administrator'],
            ['created_time'=>time(),'user_id'=>3,'nick_name'=>'admin','sex'=>10,'introduction'=>'I am an administrator'],
            ['created_time'=>time(),'user_id'=>4,'nick_name'=>'user','sex'=>10,'introduction'=>'I am an user'],
        ];

        DB::table('user_info')->insert($userInfoData);
    }
}
