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
            $table->string('title')->comment('标题');
            $table->integer('parent_id')->comment('上级ID')->default(0);
            $table->tinyInteger('type')->comment('类型')->default(0);
            $table->tinyInteger('check_type')->comment('检查类型');
            $table->smallInteger('total_score')->comment('总分');
            $table->smallInteger('order_by')->comment('排序')->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->comment('检查项目表');
        });

        Schema::create('check_questions', function (Blueprint $table) {
            $table->id();
            $table->string('content')->comment('问题');
            $table->string('rectify_content')->comment('措施');
            $table->string('check_method')->comment('检查方法');
            $table->integer('check_items_id')->comment('检查标准ID');

            $table->tinyInteger('type')->comment('类型');
            $table->tinyInteger('check_type')->comment('检查类型');
            $table->tinyInteger('difficulty')->comment('难度');
            $table->smallInteger('order_by')->comment('排序');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->comment('检查问题表');
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
        Schema::dropIfExists('check_questions');
    }
};
