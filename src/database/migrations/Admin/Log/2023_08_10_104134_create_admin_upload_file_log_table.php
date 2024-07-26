<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-02-02 15:08:08
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 14:55:39
 * @FilePath: d:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\src\database\migrations\Admin\Log\2023_08_10_104134_create_admin_upload_file_log_table.php
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
        Schema::create('admin_upload_file_log', function (Blueprint $table)
        {
           $table->id()->comment('主键--后台文件上传日志表');
		   $table->unsignedBigInteger('admin_id')->default(0)->comment('管理员id');
           $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
          
           $table->unsignedBigInteger('save_type')->default(0)->comment('存储类型 10本地 20存储桶');
           $table->unsignedBigInteger('use_type')->default(0)->comment('使用类型0  10系统配置 20管理员配置');

           $table->string('file_name',128)->default('')->comment('文件名');
           $table->string('file_path',128)->default('')->comment('文件路径');
           $table->string('file_extension',12)->default('')->comment('文件后缀');
           $table->string('file',128)->default('')->comment('文件');
           $table->string('file_url',255)->default('')->comment('文件url (存储桶类型)');
           $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
           $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
           $table->dateTime('updated_at')->nullable()->comment('更新时间string');
           $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
           $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
           $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');

        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}admin_upload_file_log` comment '后台文件上传日志表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_upload_file_log');
    }
};
