<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Tree\CheckItemAction;
use App\Models\Firm;
use Dcat\Admin\Form;
use Dcat\Admin\Show;
use Dcat\Admin\Tree;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Tree\Actions;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\CheckItem;
use App\Admin\Actions\Tree\SetCheckQuestion;
use Dcat\Admin\Http\Controllers\AdminController;

class CheckItemController extends AdminController
{
    public function index(Content $content)
    {
        Admin::js('/js/checkItem.js');
        $checkType = request()->query('check_type');
        return $content->header('树状模型')
            ->body(function (Row $row) use ($checkType) {
                $tree = new Tree(\App\Models\CheckItem::with(['checkQuestions']));

                $row->column(12, $tree);
                if (!empty($checkType)) {
                    $tree->query(function ($model) use ($checkType) {
                        return $model->where('check_type', $checkType);
                    });
                }

                $tree->branch(function ($branch) {
                    switch ($branch['type']) {
                        case 1:
                            $button = "<span class='label' style='background-color: #009587'>检查项目</span><span class='label' style='background-color: #009587'>总分：{$branch['total_score']}分</span><br>{$branch['title']}";
                            break;
                        case 2:
                            $button = "<span class='label' style='background-color: #1e9efe'>检查内容</span><br>{$branch['title']}";
                            break;
                        case 3:
                            $button = "<span class='label' style='background-color: #fdb701'>检查标准</span><span class='label' style='background-color: #fdb701'>扣{$branch['total_score']}分</span><br>{$branch['title']}";
                            break;
                        case 4:
                        default:
                            $button = "<span class='label' style='background-color: #fd5722'>检查问题</span><br>{$branch['title']}";
                            break;
                    }
                    return $button;
                });
                $tree->actions(function (Actions $actions) {
                    if ($actions->row->type !== 4) {
                        $actions->append(new SetCheckQuestion());
                    }
                });
                $tree->tools(function (Tree\Tools $tools) {
                    $tools->add(new CheckItemAction());
                });
                $tree->maxDepth(4);
                $tree->disableSaveButton();
                $tree->expand();
            });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new CheckItem(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('parent_id');
            $show->field('type');
            $show->field('check_type');
            $show->field('total_score');
            $show->field('order_by');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new CheckItem(), function (Form $form) {
            $model = $form->model();
            if ($model->type != 4) {
                $form->text('title')->required();

                $form->select('parent_id')
                    ->options(\App\Models\CheckItem::selectOptions())
                    ->required()
                    ->saving(function ($v) {
                        return (int) $v;
                    });

                $form->select('check_type', '所属检查类型')->options(Firm::$formatCheckTypeMaps)->required();
                if (in_array($model->type, [1, 3])) {
                    $form->number('total_score')->required();
                }
                $form->hidden('type')->value(0);
                $form->number('order_by')->required();
            } else {
                $form->text('title', '标准问题')->required();
                $form->text('rectify_content', '整改措施')->required();
                $form->text('check_method', '检查方法')->required();
                $form->select('difficulty', '整改难度')->required()->options(\App\Models\CheckItem::$formatDifficultyMaps)->required();

                $form->select('parent_id')
                    ->options(\App\Models\CheckItem::selectOptions())
                    ->required()
                    ->saving(function ($v) {
                        return (int) $v;
                    });
                $form->number('order_by')->required();
                $form->select('check_type', '所属检查类型')->options(Firm::$formatCheckTypeMaps)->required();
            }

            $form->creating(function (Form $form) {
                $parentId = $form->input('parent_id') ?? 0;
                if ($parentId != 0) {
                    $parent = \App\Models\CheckItem::select(['id', 'type'])->find($parentId);
                    if ($parent->type >= 3) {
                        // 中断后续逻辑
                        return $form->response()->error('该层级下无法再添加');
                    }
                    $form->input('type', $parent->type + 1);
                    $form->input('check_type', $parent->check_type);
                } else {
                    $form->input('type', 1);
                }
                return;
            });
        });
    }
}
