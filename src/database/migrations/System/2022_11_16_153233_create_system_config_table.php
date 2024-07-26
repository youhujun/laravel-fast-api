<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-11-16 15:32:33
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 23:19:22
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
       Schema::create('system_config', function (Blueprint $table)
        {
            $table->increments('id')->comment('主键');
			$table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
			$table->unsignedTinyInteger('parent_id')->default(0)->comment('父级id');
			$table->unsignedTinyInteger('deep')->default(0)->comment('深度级别');
            $table->unsignedTinyInteger('item_type')->default(0)->comment('值的类型  10标签 20字符串 30数值 40路径');
			
            $table->string('item_label',128)->default('')->comment('配置项标签');
            $table->string('item_value',128)->default('')->comment('配置项值');
            $table->decimal('item_price',32,8,true)->default(0)->comment('配置项数值,一般为金额或积分');
			$table->string('item_path',255)->default('')->comment('文件路径');
            $table->string('item_introduction',255)->default('')->comment('配置项说明');

            $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
			$table->unsignedTinyInteger('sort')->index()->default(100)->comment('排序');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}system_config` comment '系统配置表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         Schema::dropIfExists('system_config');
    }
};
