<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-10-18 09:01:47
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-05 17:42:45
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
        Schema::create('category', function (Blueprint $table) {

           $table->id()->comment('主键');
		   $table->unsignedInteger('parent_id')->default(0)->comment('父级id');
           $table->unsignedTinyInteger('deep')->default(0)->comment('级别');
           $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
           $table->unsignedTinyInteger('switch')->default(0)->comment('是否|开关 0关否1是开');
           $table->decimal('rate',4,2)->default(0)->comment('分润比例%');
           $table->string('category_name',64)->default('')->comment('分类名称');
           $table->string('category_code',64)->unique()->nullable()->comment('分类逻辑名称');
           $table->unsignedBigInteger('category_picture_id')->default(0)->comment('分类图片id(相册图片id)');
           $table->string('remark_info',255)->nullable()->comment('备注说明');

		   $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
           $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
           $table->dateTime('updated_at')->nullable()->comment('更新时间string');
           $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
           $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
           $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
		   $table->unsignedTinyInteger('sort')->default(0)->comment('排序');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}category` comment '文章分类表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
};
