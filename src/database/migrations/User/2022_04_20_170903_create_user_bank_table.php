<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-20 17:09:03
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-04-06 16:22:14
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
        Schema::create('user_bank', function (Blueprint $table) {

           $table->id()->comment('主键 用户银行信息表');
		   $table->unsignedBigInteger('user_id')->default(0)->comment('用户id');
           $table->unsignedInteger('bank_id')->default(0)->comment('银行id');
		   $table->unsignedBigInteger('bank_front_id')->default(0)->comment('银行卡正面(相册图片表id)');
           $table->unsignedBigInteger('bank_back_id')->default(0)->comment('银行卡背面(相册图片表id)');
           $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
           $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认 0不 1是');
           $table->string('bank_number',32)->default('')->comment('银行卡号');
           $table->string('bank_account',32)->default('')->comment('银行户名');
           $table->string('bank_address',64)->default('')->comment('开户行地址');

		   $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
           $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
           $table->dateTime('updated_at')->nullable()->comment('更新时间string');
           $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
           $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
           $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
		   $table->unsignedTinyInteger('sort')->default(100)->comment('排序');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_bank` comment '用户银行信息表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bank');
    }
};
