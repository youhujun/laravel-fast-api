<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-08-23 16:59:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-04-06 16:27:13
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
        Schema::create('user_picture', function (Blueprint $table) {
            $table->id()->comment('主键');
			$table->unsignedBigInteger('user_id')->default(0)->comment('用户id');
            $table->unsignedBigInteger('album_picture_id')->default(0)->comment('图片相册id');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认 0否 1是');
            $table->unsignedTinyInteger('type')->default(0)->comment('图片类型');
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

        DB::statement("ALTER TABLE `{$prefix}user_picture` comment '用户图片表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_picture');
    }
};
