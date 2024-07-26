<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-16 15:57:22
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-25 21:45:46
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
        Schema::create('user_address', function (Blueprint $table) {

            $table->id()->comment('主键');
            $table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
			$table->unsignedTinyInteger('address_type')->default(0)->comment('地址类型 默认0家庭10工作20 学校30 其他40');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认地址 0否1是');

            $table->string('address_info',255)->default('')->comment('地址详情');
            $table->unsignedTinyInteger('country_id')->default(0)->comment('国家或地区id');
            $table->unsignedInteger('province_id')->default(0)->comment('省id');
            $table->unsignedInteger('region_id')->default(0)->comment('地区id');
            $table->unsignedInteger('city_id')->default(0)->comment('城市id');
            $table->unsignedBigInteger('towns_id')->default(0)->comment('城镇id');
            $table->unsignedBigInteger('village_id')->default(0)->comment('小区或村id');
            
			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_address` comment '用户地址表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_address');
    }
};
