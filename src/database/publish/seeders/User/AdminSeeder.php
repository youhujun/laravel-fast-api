<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-07-24 14:49:06
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 10:28:12
 * @FilePath: \base.laravel.comd:\wwwroot\Working\PHP\Laravel\api.laravel.com\database\seeders\User\AdminSeeder.php
 */


namespace Database\Seeders\User;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminData = [
            ['account_name'=>'develop','user_id'=>1,'created_at'=>date('Y-m-d H:i:s',time()),'password'=>Hash::make('abc321'),'created_time'=>time(),'switch'=>1],
            ['account_name'=>'super','user_id'=>2,'created_at'=>date('Y-m-d H:i:s',time()),'password'=>Hash::make('abc321'),'created_time'=>time(),'switch'=>1],
        ];
        DB::table('admin')->insert($adminData);
    }
}
