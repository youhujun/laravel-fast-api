<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('主键');;
            $table->string('queue')->index()->comment('队列');
            $table->longText('payload')->comment('有效载荷');
            $table->unsignedTinyInteger('attempts')->comment('允许尝试次数');
            $table->unsignedInteger('reserved_at')->nullable()->comment('重新尝试时间');
            $table->unsignedInteger('available_at')->comment('完成时间');
            $table->unsignedInteger('created_at')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
