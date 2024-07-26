<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: YouHuJun
 * @Date: 2023-04-03 09:17:09
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 18:42:41
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
        Schema::create('user_apply_real_auth', function (Blueprint $table) 
		{
            $table->id()->comment('主键');
			$table->unsignedBigInteger('user_id')->default(0)->comment('用户id');
			$table->unsignedBigInteger('admin_id')->default(0)->comment('审核的管理员id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 10申请中  20通过 30拒绝');
			$table->dateTime('auth_apply_at')->nullable()->comment('实名认证申请时间string');
            $table->unsignedInteger('auth_apply_time')->index(0)->default(0)->comment('实名认证申请时间int');
            $table->dateTime('auth_at')->nullable()->comment('实名认证审核时间string');
            $table->unsignedInteger('auth_time')->default(0)->comment('实名认证审核时间int');
			$table->string('refuse_info',64)->default('')->comment('拒绝原因');

			 $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_apply_real_auth` comment '用户申请实名认证表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_apply_real_auth');
    }
};
