<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-03-24 10:44:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-22 11:13:53
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
        Schema::create('level_item', function (Blueprint $table) 
		{
            $table->id()->comment('主键');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            
            $table->unsignedTinyInteger('type')->default(0)->comment('配置项类型 10数值 20百分比 30时间');
            $table->string('item_name',32)->unique()->nullable()->comment('配置项名称 唯一');
            $table->string('item_code',32)->unique()->nullable()->comment('配置项代码 唯一');
            $table->string('description',64)->default('')->comment('描述');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}level_item` comment '级别配置项表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_item');
    }
};
