<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-21 08:56:55
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 15:16:20
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
        Schema::create('user_balance_log', function (Blueprint $table) {

            $table->id()->comment('主键--用户余额日志表');
			$table->unsignedBigInteger('user_id')->default(0)->comment('用户id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedTinyInteger('type')->default(0)->comment('0未知 10充值 20 支出  30退款');
            $table->decimal('amount',32,8)->default(0)->comment('实际金额');
            $table->decimal('change_value',32,8)->default(0)->comment('变动数值');
            $table->decimal('balance',32,8)->default(0)->comment('余额');
            $table->string('remark_info',32)->nullable()->comment('备注');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
			$table->unsignedTinyInteger('sort')->default(100)->comment('排序');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_balance_log` comment '用户余额日志表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_balance_log');
    }
};
