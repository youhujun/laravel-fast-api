<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-01-04 10:13:44
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-01-04 11:06:28
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
        Schema::create('article_info', function (Blueprint $table) {

           $table->id()->comment('主键');
           $table->unsignedBigInteger('article_id')->default(0)->comment('文章id');
           $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
           $table->text('article_info')->nullable()->comment('文章详情');

		   $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
           $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
           $table->dateTime('updated_at')->nullable()->comment('更新时间string');
           $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
           $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
           $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');


        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}article_info` comment '文章详情表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_info');
    }
};
