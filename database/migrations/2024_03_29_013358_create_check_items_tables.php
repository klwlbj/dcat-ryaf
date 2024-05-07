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
        Schema::create('check_items', function (Blueprint $table) {
            $table->id();
            $table->string('title', 1000)->comment('标题');
            $table->integer('parent_id')->comment('上级ID')->default(0);
            $table->tinyInteger('type')->comment('类型')->default(0);
            $table->tinyInteger('check_type')->comment('检查类型');
            $table->smallInteger('total_score')->comment('总分')->default(0);
            $table->smallInteger('order_by')->comment('排序')->default(0);

            $table->string('rectify_content', 1000)->comment('措施')->default('');
            $table->string('check_method')->comment('检查方法')->default('');
            $table->tinyInteger('difficulty')->comment('难度')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->comment('检查项目表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_items');
    }
};
