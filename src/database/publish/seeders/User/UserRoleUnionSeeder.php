<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-09-03 21:33:29
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-06 22:34:12
 */

namespace Database\Seeders\User;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UserRoleUnionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //先获取所有的角色id
        $roleCollection = DB::table('role')->select(['id'])->orderBy('id','asc')->get();

        //角色id容器
        $roleIdArray = [];
        //开发者
        $developRoleUninData = [];
        //超级管理员
        $superRoleUninData = [];

        foreach ($roleCollection as $key => $value)
        {
           $roleIdArray[] = $value->id;

           $developRoleUninData[] = [
                'created_time' => time(),
                'created_at' => date('Y-m-d H:i:s',\time()),
                'user_id' => 1,
                'role_id'=>$value->id
           ];

           $superRoleUninData[] =  [
                'created_time' => time(),
                'created_at' => date('Y-m-d H:i:s',\time()),
                'user_id' => 2,
                'role_id'=>$value->id
           ];

        }

        $userRoleUnionData = [
            ['user_id'=>3,'role_id'=>3,'created_time'=>time()],
            ['user_id'=>3,'role_id'=>4,'created_time'=>time()],
            ['user_id'=>4,'role_id'=>4,'created_time'=>time()],

        ];

        DB::table('user_role_union')->insert($developRoleUninData);
        DB::table('user_role_union')->insert($superRoleUninData);
        DB::table('user_role_union')->insert($userRoleUnionData);
    }
}
