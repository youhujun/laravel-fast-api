<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-07-24 14:49:06
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 22:40:39
 * @FilePath: \database\seeders\User\UserSeeder.php
 */

namespace Database\Seeders\User;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            ['account_name'=>'develop','password'=>Hash::make('abc321'),'created_time'=>time(),'switch'=>1,'auth_token'=>Str::random(20),'source_id'=>0,'real_auth_status'=>10,'invite_code'=>'0001'],
            ['account_name'=>'super','password'=>Hash::make('abc321'),'created_time'=>time(),'switch'=>1,'auth_token'=>Str::random(20),'source_id'=>1,'real_auth_status'=>10,'invite_code'=>'0002'],
            ['account_name'=>'admin','password'=>Hash::make('abc321'),'created_time'=>time(),'switch'=>1,'auth_token'=>Str::random(20),'source_id'=>1,'real_auth_status'=>10,'invite_code'=>'0003'],
            ['account_name'=>'user','password'=>Hash::make('abc321'),'created_time'=>time(),'switch'=>1,'auth_token'=>Str::random(20),'source_id'=>1,'real_auth_status'=>10,'invite_code'=>'0004'],
        ];

        DB::table('users')->insert($userData);
    }
}
