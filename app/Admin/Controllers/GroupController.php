<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Repositories\Group;
use Dcat\Admin\Http\Controllers\AdminController;

class GroupController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Group(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            // 禁用详情按钮
            $grid->disableViewButton();
            // 默认为每页20条
            $grid->paginate(15);

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->expand();
                $filter->like('name')->width(3);
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
        return Show::make($id, new Group(), function (Show $show) {
            $show->field('id');
            $show->field('name');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Group(), function (Form $form) {
            // $form->display('id');
            $form->text('name');
        });
    }
}
