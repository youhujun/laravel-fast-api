<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-07 14:53:00
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 15:14:42
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
        Schema::create('replace', function (Blueprint $table) {

           $table->id()->comment('主键--替换模板表');

           $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');

           $table->unsignedTinyInteger('switch')->default(0)->comment('是否|开关 0关否1是开');
		   $table->unsignedTinyInteger('status')->default(0)->comment('状态');
           $table->unsignedTinyInteger('deep')->default(0)->comment('级别');
           $table->unsignedTinyInteger('is_default')->default(0)->comment('是否常用 0不 1是');
           $table->string('name',32)->unique()->nullable()->comment('名称 唯一');
           $table->char('name',32)->unique()->nullable()->comment('名称 唯一');

		   $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
           $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
           $table->dateTime('updated_at')->nullable()->comment('更新时间string');
           $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
           $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
           $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
           $table->unsignedTinyInteger('sort')->default(100)->comment('排序');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}replace` comment '替换模板表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replace');
    }
};
