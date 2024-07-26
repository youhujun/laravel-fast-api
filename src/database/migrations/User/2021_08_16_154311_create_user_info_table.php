<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: YouHuJun
 * @Date: 2021-08-16 19:00:53
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-25 21:44:10
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
        Schema::create('user_info', function (Blueprint $table) {
            $table->id()->comment('主键');
            $table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->string('nick_name',64)->default('')->comment('昵称');
            $table->string('family_name',32)->default('')->comment('姓');
            $table->string('name',64)->default('')->comment('名');
            $table->string('real_name',128)->default('')->comment('真实姓名');
            $table->string('id_number',32)->unique()->nullable()->comment('身份证号');
            $table->unsignedTinyInteger('sex')->default(0)->comment('性别 0未知10男20女');
            $table->date('solar_birthday_at')->nullable()->comment('阳历生日string');
            $table->unsignedInteger('solar_birthday_time')->default(0)->comment('阳历生日');
            $table->date('chinese_birthday_at')->nullable()->comment('阴日生日');
            $table->unsignedInteger('chinese_birthday_time')->default(0)->comment('阴日生日');
            $table->string('introduction',255)->default('')->comment('简介');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_info` comment '用户信息表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_info');
    }
};
