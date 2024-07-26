<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-13 14:58:33
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-24 23:00:22
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission_union', function (Blueprint $table) {

          $table->id()->comment('主键');
          $table->unsignedInteger('permission_id')->default(0)->index()->comment('用户id');
          $table->unsignedTinyInteger('role_id')->default(0)->index()->comment('角色id');

		  $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
          $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
		   $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}role_permission_union` comment '角色和权限菜单关联表'");

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission_union');
    }
};
