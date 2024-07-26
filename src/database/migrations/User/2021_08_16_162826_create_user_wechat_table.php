<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-16 16:28:26
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-08 10:17:29
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
        Schema::create('user_wechat', function (Blueprint $table) {

			$table->id()->comment('主键');

			$table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户id');
			$table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
			$table->string('openid',100)->unique()->nullable()->comment('唯一openid');
			$table->string('wechat_official_appid',100)->default('')->comment('微信公众号appid');
			$table->dateTime('wechat_verified_at')->nullable()->comment('微信号认证时间string');
			$table->unsignedInteger('wechat_verified_time')->default(0)->comment('微信号认证时间int');
			
			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
			$table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
			$table->dateTime('updated_at')->nullable()->comment('更新时间string');
			$table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
			$table->dateTime('deleted_at')->nullable()->comment('删除时间string');
			$table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');


        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_wechat` comment '用户微信表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wechat');
    }
};
