<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-10-18 09:00:29
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-25 23:32:40
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

        Schema::create('goods_class', function (Blueprint $table) {

            $table->id()->comment('主键');
			 $table->unsignedInteger('parent_id')->default(0)->comment('父级id');
            $table->unsignedTinyInteger('deep')->default(0)->comment('级别');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->unsignedTinyInteger('switch')->default(0)->comment('是否|开关 0关否1是开');
            $table->decimal('rate',4,2)->default(0)->comment('分润比例%');
            $table->string('goods_class_name',64)->default('')->comment('商品类名称');
            $table->string('goods_class_code',64)->unique()->nullable()->comment('商品分类逻辑名称');
            $table->unsignedBigInteger('goods_class_picture_id')->default(0)->comment('分类图片id(相册图片id)');
            $table->unsignedTinyInteger('is_certificate')->default(0)->comment('是否需要要资质证书 0否1是');
            $table->unsignedTinyInteger('certificate_number')->default(0)->comment('主要资质证书数量');
        	$table->string('remark_info',255)->nullable()->comment('备注说明');
			
		    $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->useCurrentOnUpdate()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
		    $table->unsignedTinyInteger('sort')->default(0)->comment('排序');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}goods_class` comment '产品分类表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_class');
    }
};
