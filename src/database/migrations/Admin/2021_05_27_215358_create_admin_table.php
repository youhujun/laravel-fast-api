<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-27 21:53:58
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 15:09:20
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
        Schema::create('admin', function (Blueprint $table) {
            $table->id()->comment('主键');
            $table->unsignedBigInteger('user_id')->index()->default(0)->comment('用户id');
            $table->unsignedTinyInteger('switch')->index()->default(0)->comment('是否|开关 0关否1是开');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
			$table->string('remember_token',128)->unique()->nullable()->comment('记住token');
			$table->string('account_name',64)->unique()->nullable()->comment('账户名称 唯一');
			$table->string('phone_area_code',15)->default('')->comment('手机号区号');
            $table->char('phone',12)->unique()->nullable()->comment('手机号');
            $table->string('password',255)->default('')->comment('密码');
			 $table->dateTime('phone_verified_at')->nullable()->comment('手机号认证时间string');
            $table->unsignedInteger('phone_verified_time')->default(0)->comment('手机号认证时间int');
            $table->string('email',128)->unique()->nullable()->comment('邮箱');
            $table->dateTime('email_verified_at')->nullable()->comment('邮箱认证时间string');
            $table->unsignedInteger('email_verified_time')->default(0)->comment('邮箱认证时间int');

            $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->index(0)->default(0)->comment('跟新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}admin` comment '管理员表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
};
