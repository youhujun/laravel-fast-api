<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-23 15:35:15
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-08-22 14:44:57
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
        Schema::create('failed_jobs', function (Blueprint $table) {

            $table->id()->comment('主键');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedInteger('failed_time')->index(0)->default(0)->comment('失败时间int');
            $table->dateTime('failed_at')->useCurrent()->comment('失败时间string');
            $table->string('uuid',100)->unique()->comment('唯一标识');
            $table->text('connection')->comment('连接');
            $table->text('queue')->comment('队列');
            $table->longtext('payload')->comment('有效载荷');
            $table->longtext('exception')->comment('异常');

        });
        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}failed_jobs` comment '失败队列表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
};
