<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称');
            $table->integer('area_id')->default(0)->comment('单位');
            $table->string('check_unit')->default('')->comment('检查单位');
            $table->string('notification_title')->default('')->comment('通知书标题');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->comment('系统项目表');
        });

        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('名称');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->comment('区域表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_items');
        Schema::dropIfExists('areas');
    }
};
