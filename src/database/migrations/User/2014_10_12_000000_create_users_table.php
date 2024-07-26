<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-23 15:35:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 15:17:25
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
        Schema::create('users', function (Blueprint $table) {

            $table->id()->comment('主键');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
           
            $table->unsignedTinyInteger('switch')->default(0)->comment('是否|开关 0关否1是开');
            $table->unsignedBigInteger('source_id')->default(0)->comment('推荐人id');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父级id');
			$table->tinyInteger('real_auth_status')->default(0)->comment('实名认证状态 10未认证 20认证中 30未通过 40认证通过');
            $table->tinyInteger('level_id')->default(0)->comment('用户级别id');
			$table->string('remember_token',128)->unique()->nullable()->comment('记住token');
            $table->string('auth_token',128)->unique()->nullable()->comment('auth_token');
            $table->string('account_name',64)->unique()->nullable()->comment('账户名称 唯一');
            $table->char('invite_code',12)->unique()->nullable()->comment('唯一邀请码');
            $table->string('phone_area_code',15)->default('')->comment('手机号区号');
            $table->char('phone',12)->unique()->nullable()->comment('手机号');
            $table->string('password',255)->default('')->comment('密码');

			$table->unsignedDecimal('balance',32,8)->default(0)->comment('余额');
            $table->unsignedDecimal('coin',32,8)->default(0)->comment('系统币');
            $table->unsignedDecimal('score',32,8)->default(0)->comment('积分');

            $table->dateTime('phone_verified_at')->nullable()->comment('手机号认证时间string');
            $table->unsignedInteger('phone_verified_time')->default(0)->comment('手机号认证时间int');
            $table->string('email',128)->unique()->nullable()->comment('邮箱');
            $table->dateTime('email_verified_at')->nullable()->comment('邮箱认证时间string');
            $table->unsignedInteger('email_verified_time')->default(0)->comment('邮箱认证时间int');
           /*
            $table->string('qq',32)->unique()->nullable()->comment('qq号');
            $table->unsignedInteger('qq_verified_time')->default(0)->comment('qq号认证时间');
            $table->dateTime('qq_verified_at')->nullable()->comment('qq号认证时间'); */

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}users` comment '用户表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
