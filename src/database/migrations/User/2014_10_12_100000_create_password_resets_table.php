<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: YouHuJun
 * @Date: 2022-02-09 20:38:38
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-14 21:19:21
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
        Schema::create('password_resets', function (Blueprint $table) {

            $table->id()->comment('主键');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->string('email',128)->index()->default('')->comment('邮箱');
            $table->char('phone',12)->index()->default('')->comment('手机号');
            $table->string('token',255)->default('')->comment('令牌');
			
			$table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间');
            $table->dateTime('created_at')->useCurrent()->comment('创建时间');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}password_resets` comment '密码重置表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
