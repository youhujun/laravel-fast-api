<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-28 00:08:41
 * @LastEditors: YouHuJun
 * @LastEditTime: 2021-09-29 15:57:57
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
        Schema::create('region', function (Blueprint $table) {

            $table->id()->comment('主键');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedInteger('parent_id')->default(0)->comment('父级id');
            $table->unsignedTinyInteger('deep')->default(0)->index()->comment('深度');
            $table->string('region_name',64)->default('')->comment('地区名称');
            $table->string('region_area',32)->default('')->comment('大区名称');
			
			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->index()->comment('排序');


        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}region` comment '系统地区表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region');
    }
};
