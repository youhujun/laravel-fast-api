<?php

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
        Schema::create('user_location_log', function (Blueprint $table)
        {
            $table->id()->comment('主键');
            $table->unsignedBigInteger('user_id')->default(0)->comment('用户id');
            $table->tinyInteger('type')->default(0)->comment('类型 10用户');
            $table->unsignedBigInteger('revision')->default(0)->comment('乐观锁');
			$table->decimal('latitude',32,10,true)->default(0)->comment('维度');
			$table->decimal('longitude',32,10,true)->default(0)->comment('经度');
			$table->string('address',128)->default('')->comment('位置信息');

            $table->dateTime('created_at')->useCurrent()->comment('创建时间string');
            $table->unsignedInteger('created_time')->index(0)->default(0)->comment('创建时间int');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间string');
            $table->unsignedInteger('deleted_time')->default(0)->comment('删除时间int');
            $table->unsignedTinyInteger('sort')->default(100)->comment('排序');
        });

        $prefix = config('database.connections.mysql.prefix');

        DB::statement("ALTER TABLE `{$prefix}user_location_log` comment '用户位置信息记录表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_location_log');
    }
};
