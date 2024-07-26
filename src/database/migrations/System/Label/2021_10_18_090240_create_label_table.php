<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-10-18 09:02:40
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-11 20:34:38
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
        Schema::create('label', function (Blueprint $table) {
            $table->id()->comment('主键');

            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedInteger('parent_id')->default(0)->comment('父级id');
            $table->unsignedTinyInteger('deep')->default(0)->comment('级别');
            $table->unsignedTinyInteger('switch')->default(0)->comment('是否|开关 0关否1是开');
            $table->string('label_name',64)->default('')->comment('标签名称');
            $table->string('label_code',64)->unique()->nullable()->comment('标签代码');
            $table->unsignedBigInteger('label_picture_id')->default(0)->comment('标签图片id(相册图片id)');
            $table->string('remark_info',255)->nullable()->comment('备注说明');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
			$table->unsignedTinyInteger('sort')->default(0)->comment('排序');

         });

         $prefix = config('database.connections.mysql.prefix');

         DB::statement("ALTER TABLE `{$prefix}label` comment '标签表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('label');
    }
};
