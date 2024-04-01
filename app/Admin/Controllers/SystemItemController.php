<?php

namespace App\Admin\Controllers;

use App\Models\Area;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Repositories\SystemItem;
use Dcat\Admin\Http\Controllers\AdminController;

class SystemItemController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SystemItem(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('area_id')->using(\App\Models\Area::all()->pluck('name', 'id')->toArray(), '未知');
            $grid->column('check_unit');
            $grid->column('notification_title');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
            // 禁用详情按钮
            $grid->disableViewButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new SystemItem(), function (Form $form) {
            // $form->display('id');
            $form->text('name')->required();

            $areas = Area::all()->pluck('name', 'id');

            $form->select('area_id')->options($areas)->required();
            $form->text('check_unit')->required();
            $form->text('notification_title')->required();

        });
    }
}
