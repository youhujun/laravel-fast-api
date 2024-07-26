<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-01-06 12:36:10
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-06 20:11:25
 * @FilePath: \api.laravel.com_LV9\database\seeders\System\RolePermissionSeeder.php
 */


namespace Database\Seeders\System;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //先查询 所有的菜单路由
         $permissionCollection = DB::table('permission')->select(['id'])->orderBy('id','asc')->get();

         //选线容器
         $permissionIdArray = [];

         //角色和菜单权限数据容器
         //开发者
         $developPermissionUnionData = [];
         //超级管理员
         $superPermissionUnionData = [];

        foreach ($permissionCollection as $key => $value)
        {
            $permissionIdArray[] = $value->id;

            $developPermissionUnionData[] = [
                'permission_id' => $value->id,
                //开发者
                'role_id' => 1,
                'created_at' => date('Y-m-d H:i:s',time()),
                'created_time' => time()
            ];

            $superPermissionUnionData[] = [
                'permission_id' => $value->id,
                //超级管理员
                'role_id' => 2,
                'created_at' => date('Y-m-d H:i:s',time()),
                'created_time' => time()
            ];
        }

        //开发者
        DB::table('role_permission_union')->insert($developPermissionUnionData);

        //超级管理员
        DB::table('role_permission_union')->insert($superPermissionUnionData);
    }
}
