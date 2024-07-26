<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-09-09 13:42:58
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-25 22:38:28
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_login_log', function (Blueprint $table)
        {

           $table->id()->comment('主键');
           $table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户id');
           $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
           $table->unsignedTinyInteger('status')->default(0)->comment('状态 0未知 10登录 20退出');
           $table->string('instruction',64)->default('')->comment('说明');
           $table->string('ip',64)->default('')->comment('ip地址');
           $table->unsignedTinyInteger('source_type')->default(0)->comment('登录来源类型 10phone 20pc');
		   $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
           $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
           $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
           $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
          
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_login_log` comment '用户登录退出日志表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_login_log');
    }
};
