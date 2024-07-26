<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-25 11:04:02
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 08:52:44
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_source_union', function (Blueprint $table) {

            $table->id()->comment('主键--用户父关联表');
			 $table->unsignedBigInteger('user_id')->default(0)->comment('用户id');
            $table->unsignedBigInteger('first_id')->default(0)->comment('一级id');
            $table->unsignedBigInteger('second_id')->default(0)->comment('二级id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
			$table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_source_union` comment '用户父关联表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_source_union');
    }
};
