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
        Schema::create('check_results', function (Blueprint $table) {
            $table->id();
            $table->uuid('report_code')->unique()->comment('检查报告唯一识别码');
            $table->tinyInteger('status')->comment('检查状态')->default(0);
            $table->integer('total_point')->comment('总分')->default(0);
            $table->integer('check_user_id')->comment('检查人')->default(0);
            $table->integer('deduction_point')->comment('扣分')->default(0);
            $table->integer('rectify_number')->comment('隐患数')->default(0);
            $table->string('firm_id', 36)->comment('企业id');
            $table->json('history_check_item')->comment('历史检查项目字段')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->comment('系统结果报告表');
        });

        Schema::create('check_questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('check_result_uuid')->comment('检查报告uuid');

            $table->string('question')->comment('问题')->default('');
            $table->string('rectify')->comment('措施')->default('');
            $table->tinyInteger('difficulty')->comment('难度')->default(0);
            $table->integer('check_standard_id')->comment('检查标准id')->default(0);
            $table->string('check_question_id', 36)->comment('检查问题id')->default(0);
            $table->string('firm_id', 36)->comment('企业id');
        });

        Schema::create('collect_images', function (Blueprint $table) {
            $table->id();

            $table->uuid();
            $table->string('file_name')->comment('文件名')->default('');
            $table->string('file_path')->comment('路径')->default('');
            $table->string('file_extension')->comment('文件拓展名')->default('');
            $table->string('report_code')->comment('报告id')->default('');
            $table->string('firm_id', 36)->comment('企业id')->default(0);
            $table->integer('check_question_id')->comment('检查问题id')->default(0);

            $table->comment('图片表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_results');
        Schema::dropIfExists('check_questions');
        Schema::dropIfExists('collect_images');
    }
};
