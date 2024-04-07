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
            return $this
                ->response()
                ->error('上级不存在');
        }
        if ($parent->type != 3) {
            return $this
                ->response()
                ->error('无法添加');
        }

        $checkItem = CheckItem::create([
            'title'           => $input['title'],
            'parent_id'       => $input['parent_id'],
            'rectify_content' => $input['rectify_content'],
            'check_method'    => $input['check_method'],
            'order_by'        => $input['order_by'],
            'type'            => $parent->type + 1,
            'check_type'      => $parent->check_type,
        ]);

        if ($checkItem) {
            return $this
                    ->response()
                    ->success('添加完成')
                    ->refresh();
        }
        return $this
            ->response()
            ->error('添加失败');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $parentId = $this->payload['parent_id'] ?? null;

        $this->hidden('parent_id')->value($parentId)->required();
        $this->text('title', '标准问题')->required();
        $this->text('rectify_content', '整改措施')->required();
        $this->text('check_method', '检查方法')->default('现场检查')->required();
        $this->select('difficulty', '整改难度')->options(CheckItem::$formatDifficultyMaps)->required();
        $this->number('order_by', '排序')->default('0')->required();
    }
}
