<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-16 10:12:23
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-14 21:58:23
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
        Schema::create('user_avatar', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户id');
            $table->unsignedBigInteger('album_picture_id')->default(0)->index()->comment('相册图片id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认使用 0否1是 ');

            $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');


        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_avatar` comment '用户头像表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_avatar');
    }
};
