<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\Group;
use App\Admin\Repositories\User;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('email');
            $grid->column('phone');
            $grid->column('type');
            $grid->column('group_id');
            $grid->column('status');
            $grid->column('job_info');
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->expand();
                $filter->equal('id')->width(3);
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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('email');
            $show->field('phone');
            $show->field('type');
            $show->field('group_id');
            $show->field('status');
            $show->field('job_info');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->email('email', '邮箱');
            $form->mobile('phone', '手机号')->options(['mask' => '99999999999']);

            // 枚举值
            $types = [
                1 => 'xx',
                2 => 'yy',
            ];
            $form->select('type', '类型')->options(\App\Models\User::$formatTypeMaps)->required();
            $form->select('group_id', '分组')->options(Group::all()->pluck('name', 'id'))->required();
            $form->select('status', '状态')->options(\App\Models\User::$formatStatusMaps);
            $form->text('job_info');
            $form->password('password');

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }

                if (!$form->password) {
                    $form->deleteInput('password');
                }
            });
        });
    }
}
