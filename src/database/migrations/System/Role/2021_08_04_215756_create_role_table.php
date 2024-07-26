<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-13 14:58:33
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-14 21:57:04
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
        Schema::create('role', function (Blueprint $table)
        {
            $table->increments('id')->comment('主键');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedTinyInteger('parent_id')->index()->default(0)->comment('父级id');
            $table->unsignedTinyInteger('deep')->index()->default(0)->comment('深度级别');
            $table->unsignedTinyInteger('switch')->index()->default(0)->comment('是否|开关 0关否1是开');
            $table->string('role_name',32)->default('')->comment('角色名称');
            $table->string('logic_name',64)->default('')->comment('逻辑名称');

			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
			$table->unsignedTinyInteger('sort')->index()->default(100)->comment('排序');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}role` comment '角色表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
};
