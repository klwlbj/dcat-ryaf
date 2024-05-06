<?php

namespace App\Admin;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\CheckItem;
use App\Admin\Actions\AddChildCheckContent;
use Dcat\Admin\Http\Controllers\AdminController;

class CheckItemController extends AdminController
{
    /*public function index(Content $content)
    {
        return $content->body(AddChildCheckContent::make());
    }*/

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CheckItem(), function (Grid $grid) {
            // $grid->column('type');
            $grid->id('ID', '编号')->bold()->sortable();
            $grid->column('title', '检查项目')->tree(true); // 开启树状表格功能，一页加载所有树
            $grid->column('check_type')->using(\App\Models\Firm::$formatCheckTypeMaps, '未知');
            $grid->column('total_score');
            $grid->column('order_by', '排序（双击修改）')->editable(true);
            // $grid->column('created_at');
            // $grid->column('updated_at')->sortable();

            $grid->disableEditButton();

            $grid->actions([new AddChildCheckContent()]);

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->expand();
                $filter->equal('check_type')->select(\App\Models\CheckItem::$formatCheckTypeMaps)->width(3);
            });
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
            // $form->display('id');
            $form->text('title')->required();

            $form->select('parent_id')
                ->options(\App\Models\CheckItem::selectOptions())
                ->required()
                ->saving(function ($v) {
                    return (int) $v;
                });

            $form->select('check_type', '检查类型（必需和上级一样）')->options(\App\Models\Firm::$formatCheckTypeMaps)->required();
            $form->number('total_score')->required();
            $form->number('order_by')->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    public function addChildCheckContent(Content $content)
    {
        return $content
            ->title('添加检查标准')
            ->body(new Card(new \App\Admin\Forms\AddChildCheckContent()));
    }
}
