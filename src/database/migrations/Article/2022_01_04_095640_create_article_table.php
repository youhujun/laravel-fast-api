<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-01-04 09:56:40
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 20:27:31
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
        Schema::create('article', function (Blueprint $table) 
		{
            $table->id()->comment('主键');
			$table->unsignedBigInteger('admin_id')->default(0)->comment('管理员id');
			$table->unsignedBigInteger('user_id')->default(0)->comment('发布人id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->string('title',64)->default('')->comment('文章标题');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态 默认0 0未发布 10已发布');
            $table->unsignedTinyInteger('type')->default(0)->index()->comment('文章类型 默认0 0无 10公告通知');
            $table->unsignedTinyInteger('is_top')->default(0)->index()->comment('是否置顶 默认0 0不置顶 1置顶');
			$table->unsignedTinyInteger('check_status')->default(0)->index()->comment('审核状态 默认0 0 待审核 10 审核中 20审核通过 30审核不通过');

			$table->string('category_id',255)->nullable()->comment('文章分类json');
			$table->string('label_id',255)->nullable()->comment('标签分类json');
			$table->dateTime('published_at')->nullable()->comment('发布时间string');
            $table->unsignedInteger('published_time')->default(0)->comment('发布时间int');
			$table->dateTime('checked_at')->nullable()->comment('审核时间string');
            $table->unsignedInteger('checked_time')->default(0)->comment('审核时间int');
			$table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index()->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
			$table->unsignedTinyInteger('sort')->default(100)->index()->comment('排序 默认100');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}article` comment '文章表'");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
};
