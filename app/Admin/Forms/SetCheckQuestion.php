<?php

namespace App\Admin\Forms;

use App\Models\CheckItem;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;

class SetCheckQuestion extends Form implements LazyRenderable
{
    use LazyWidget;

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $parent = CheckItem::find($input['parent_id']);
        if (!$parent) {
            return $this->response()->error('上级不存在');
        }

        $checkItem = CheckItem::create([
            'title'           => $input['title'],
            'parent_id'       => $input['parent_id'],
            'rectify_content' => $input['rectify_content'] ?? '',
            'check_method'    => $input['check_method'] ?? '',
            'order_by'        => $input['order_by'] ?? 0,
            'type'            => $parent->type + 1,
            'check_type'      => $parent->check_type,
        ]);

        if ($checkItem) {
            return $this->response()
                    ->success('添加完成')
                    ->refresh();
        }
        return $this->response()
            ->error('添加失败');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $parentId = $this->payload['parent_id'] ?? null;
        $type     = $this->payload['type'] ?? null;
        $this->hidden('parent_id')->value($parentId)->required();
        switch ($type) {
            case 1:
                $this->text('title', '检查内容')->required();
                $this->number('order_by', '排序')->default('0')->required();
                break;
            case 2:
                $this->text('title', '检查标准')->required();
                $this->number('order_by', '排序')->default('0')->required();
                $this->number('total_score', '分数')->default('0')->required();

                break;
            case 3:
                $this->text('title', '标准问题')->required();
                $this->text('rectify_content', '整改措施')->required();
                $this->text('check_method', '检查方法')->default('现场检查')->required();
                $this->number('order_by', '排序')->default('0')->required();
                $this->select('difficulty', '整改难度')->options(CheckItem::$formatDifficultyMaps)->default(CheckItem::DIFFICULTY_EASY)->required();
                break;
        }
    }
}
