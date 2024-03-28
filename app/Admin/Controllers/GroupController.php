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
            $grid->column('pid');
            // 禁用详情按钮
            $grid->disableViewButton();
            // 默认为每页20条
            $grid->paginate(15);

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
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
            $show->field('pid');
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
            // dd($form);
            $form->display('id');
            $form->text('name');

            // 查询
            $groups = \App\Models\Group::all()->pluck('name', 'id')->toArray();
            $pids   = array_merge($groups, [
                0 => '最高级',
            ]);
            $form->select('pid', '父级')->options($pids);
        });
    }
}
