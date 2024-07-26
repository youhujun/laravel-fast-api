<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-17 09:03:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 04:19:59
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
        Schema::create('album', function (Blueprint $table) 
		{

           $table->id()->comment('主键');
           $table->unsignedBigInteger('admin_id')->default(0)->index()->comment('管理员id');
           $table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户id');
           $table->unsignedBigInteger('cover_album_picture_id')->default(0)->index()->comment('用户相册图片表id 作为封面');
           $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
           $table->unsignedTinyInteger('is_default')->default(0)->comment('筛选默认相册 0否 1是');
           $table->unsignedTinyInteger('is_system')->default(0)->comment('系统分配默认相册 不可删除 0否 1是');
           $table->unsignedTinyInteger('album_type')->default(20)->comment('相册类型 默认20用户 0系统,10管理员');
           $table->string('album_name',64)->default('')->comment('相册名称');
           $table->string('album_description',255)->default('')->comment('相册描述');
		   $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
           $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
           $table->dateTime('updated_at')->nullable()->comment('更新时间string');
           $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
           $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
           $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
		   $table->unsignedTinyInteger('sort')->default(0)->comment('排序');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}album` comment '相册表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album');
    }
};