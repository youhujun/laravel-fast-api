<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-16 02:54:13
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 15:11:33
 * @FilePath: d:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\src\database\migrations\System\2024_07_16_025413_create_system_voice_config_table.php
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
        Schema::create('system_voice_config', function (Blueprint $table)
        {
            $table->id()->comment('主键');
            $table->unsignedBigInteger('admin_id')->default(0)->comment('管理员id');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');

            $table->string('voice_title',32)->default('')->comment('提示音标题');
            $table->string('channle_name',64)->default('')->comment('频道名称');
            $table->string('channle_event',32)->unique()->nullable()->comment('事件名称');
            $table->unsignedTinyInteger('voice_save_type')->index()->default(0)->comment('提示音保存方式 10 本地 20存储桶');
            $table->string('voice_url',128)->default('')->comment('提示音url');
            $table->string('voice_path',128)->default('')->comment('提示音路径');
            $table->string('voirce_file',128)->default('')->comment('提示音文件名');
            $table->string('note',128)->default('')->comment('备注');

            $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}system_voice_config` comment '系统提示音配置表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_voice_config');
    }
};
