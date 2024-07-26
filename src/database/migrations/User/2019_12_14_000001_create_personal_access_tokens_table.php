<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-01 15:27:02
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-08-22 15:24:24
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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id()->comment('个人token表主键');
            $table->string('tokenable_type',255)->comment('类型');
            $table->bigInteger('tokenable_id')->comment('id');
            $table->string('name')->comment('姓名');
            $table->string('token', 64)->unique()->comment('token');
            $table->text('abilities')->nullable()->comment('能力');
            $table->timestamp('last_used_at')->nullable()->comment('最后使用时间');
            $table->timestamps();
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}personal_access_tokens` comment '个人token表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
