<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-17 09:25:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 20:42:43
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
        Schema::create('album_picture', function (Blueprint $table) {
            $table->id()->comment('主键');
            $table->unsignedBigInteger('admin_id')->index()->default(0)->comment('管理员id');
            $table->unsignedBigInteger('user_id')->index()->default(0)->comment('用户id');
            $table->unsignedBigInteger('album_id')->index()->default(0)->comment('相册id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');

            $table->string('picture_name',64)->default('')->comment('图片名称');
            $table->string('picture_tag',64)->default('')->comment('图片标签');
            $table->string('picture_path',128)->default('')->comment('图片路径');
            $table->string('picture_file',64)->default('')->comment('图片文件');
            $table->unsignedInteger('picture_size')->default(0)->comment('图片大小(kb)');
            $table->string('picture_spec',64)->default('')->comment('图片规格(长*宽)');
			
			$table->unsignedTinyInteger('picture_type')->default(0)->comment('图片类型 10 本地 20存储桶 30微信头像');
            $table->string('picture_url',255)->default('')->comment('图片地址(存放于存储桶中)');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}album_picture` comment '用户相册图片表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_picture');
    }
};
