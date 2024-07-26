<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-03-24 10:53:32
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-30 15:08:27
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
        Schema::create('user_level_item_union', function (Blueprint $table) 
		{
            $table->id()->comment('主键');
			$table->unsignedInteger('user_level_id')->default(0)->comment('用户级别id');
            $table->unsignedInteger('level_item_id')->default(0)->comment('级别配置项id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedTinyInteger('value_type')->default(0)->comment('与参数值的关系 10等于 20大于 30小于 40大于等于 50小于等于');
            $table->unsignedInteger('value')->default(0)->comment('参数值');
           
			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_level_item_union` comment '用户级别和配置项关联表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_level_item_union');
    }
};
