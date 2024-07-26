<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-03-09 11:25:55
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-03-09 13:42:35
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
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary()->comment('批处理任务表主键');
            $table->string('name')->comment('名称');
            $table->integer('total_jobs')->comment('任务总数');
            $table->integer('pending_jobs')->comment('等待任务数');
            $table->integer('failed_jobs')->comment('失败任务数');
            $table->text('failed_job_ids')->comment('失败任务标识');
            $table->mediumText('options')->nullable()->comment('选项');
            $table->integer('cancelled_at')->nullable()->comment('取消时间');
            $table->integer('created_at')->comment('创建时间');
            $table->integer('finished_at')->nullable()->comment('完成时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_batches');
    }
};
