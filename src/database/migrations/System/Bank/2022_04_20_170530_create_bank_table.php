<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-20 17:05:30
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-05-30 11:11:44
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
        Schema::create('bank', function (Blueprint $table) {

            $table->id()->comment('银行表主键');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->string('bank_name',32)->unique()->nullable()->comment('银行名称 唯一');
            $table->string('bank_code',32)->unique()->nullable()->comment('银行名称代码 唯一');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否常用 0不 1是');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}bank` comment '系统银行表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank');
    }
};
