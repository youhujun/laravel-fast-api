<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-07-12 10:52:49
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-22 11:31:55
 * @FilePath: \api.laravel.com_LV9d:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api\Database\migrations\2023_07_12_105249_create_user_wechat_unionid_table.php
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
        Schema::create('user_wechat_unionid', function (Blueprint $table)
        {
            $table->id()->comment('主键');
			$table->unsignedBigInteger('user_id')->default(0)->comment('用户id');
            $table->string('unionid',64)->unique()->nullable()->comment('微信的unionid 唯一');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
			
            $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('updated_at')->nullable()->comment('更新时间string');
            $table->unsignedInteger('updated_time')->default(0)->comment('更新时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
            
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_wechat_unionid` comment '用户微信的unionid'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wechat_unionid');
    }
};
