<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
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
            $grid->column('password');
            $grid->column('remember_token');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('email');
            $show->field('phone');
            $show->field('type');
            $show->field('group_id');
            $show->field('status');
            $show->field('job_info');
            $show->field('password');
            $show->field('remember_token');
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->email('email', '邮箱');
            $form->mobile('phone', '手机号')->options(['mask' => '999 9999 9999']);

            // 枚举值
            $types = [
                1 => 'xx',
                2 => 'yy',
            ];
            $form->select('type', '类型')->options($types);
            $form->text('group_id');

            // 枚举值
            $statuses = [
                1 => '正常',
                2 => '停用',
            ];
            $form->select('status', '状态')->options($statuses);
            $form->text('job_info');
            $form->password('password');
        });
    }
}
