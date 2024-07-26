<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-09-09 13:43:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-25 22:39:42
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
        Schema::create('user_event_log', function (Blueprint $table) {

            $table->id()->comment('主键');

            $table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');

            $table->unsignedInteger('event_type')->default(0)->index()->comment('事件类型');
            $table->string('event_route_action',128)->default('')->comment('事件路由');
            $table->string('event_name',64)->default('')->comment('事件名称');
            $table->string('event_code',64)->default('')->comment('事件编码');
            $table->string('remark_data',1024)->default('')->comment('备注数据');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_event_log` comment '用户事件日志表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_event_log');
    }
};
