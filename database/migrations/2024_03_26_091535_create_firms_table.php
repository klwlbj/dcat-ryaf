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
        // 企业档案表
        Schema::create('firms', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name')->comment('单位名称');
            $table->integer('system_item_id')->default(0)->comment('归属项目');
            $table->integer('community')->comment('社区名称')->default(0);
            $table->string('custom_number')->comment('自定义编号')->default('');
            $table->string('head_man')->comment('负责人')->default('');
            $table->tinyInteger('status')->comment('企业状态')->default(0);
            $table->tinyInteger('check_type')->comment('检查类型')->default(0);
            $table->tinyInteger('check_result')->comment('检查结果')->default(0);
            $table->string('phone')->comment('联系方式')->default('');
            $table->string('address')->comment('地址')->default('');
            $table->integer('floor')->comment('所在层数');
            $table->integer('area_quantity')->comment('营业面积');
            $table->string('remark')->comment('备注')->default('');
            $table->json('pictures')->comment('采集信息')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

            $table->unique('custom_number');
            $table->index('name');
            $table->comment('企业档案表'); //添加表注释
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firms');
    }
};
