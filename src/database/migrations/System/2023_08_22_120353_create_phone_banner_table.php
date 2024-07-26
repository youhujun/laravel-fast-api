<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-22 12:03:53
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-25 23:12:51
 * @FilePath: \base.laravel.comd:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\src\database\migrations\System\2023_08_22_120353_create_phone_banner_table.php
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
        Schema::create('phone_banner', function (Blueprint $table)
        {
            $table->id()->comment('主键-手机轮播图');
            $table->unsignedBigInteger('admin_id')->default(0)->comment('管理员id');
            $table->unsignedBigInteger('album_picture_id')->default(0)->comment('相册图片id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
            $table->string('redirect_url',128)->nullable()->comment('跳转路径');
            $table->string('remark_info',128)->nullable()->comment('备注');

            $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}phone_banner` comment '手机轮播图'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_banner');
    }
};
