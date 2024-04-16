<?php

namespace App\Admin\Controllers;

use App\Models\SystemItem;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Admin\Repositories\Firm;
use Dcat\Admin\Http\Controllers\AdminController;

class FirmController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Firm(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('status')->using(\App\Models\Firm::$formatStatusMaps, '未知');
            $grid->column('check_result')->using(\App\Models\Firm::$formatCheckResultMaps, '未检查');
            $grid->column('name');
            $grid->column('system_item_id')->using(SystemItem::all()->pluck('name', 'id')->toArray(), '未知项目');;
            $grid->column('head_man');
            $grid->column('custom_number');
            $grid->column('phone');
            $grid->column('check_type')->using(\App\Models\Firm::$formatCheckTypeMaps, '未知');
            $grid->column('address');
            $grid->column('floor');
            $grid->column('area_quantity');
            // $grid->column('community_name');
            // $grid->column('remark');
            // $grid->column('pictures');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->withBorder();
            // 禁用详情按钮
            $grid->disableViewButton();
            // $grid->scrollbarX();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->endWith('custom_number', '编号（后几位）')->ilike();
                $filter->like('community_name');
                $filter->equal('status')->select(\App\Models\Firm::$formatStatusMaps);
                $filter->equal('system_item_id')->select(SystemItem::all()->pluck('name', 'id'));
                $filter->equal('check_type')->select(\App\Models\Firm::$formatCheckTypeMaps);
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
        return Show::make($id, new Firm(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('community_name');
            $show->field('custom_number');
            $show->field('head_man');
            $show->field('status');
            $show->field('check_type');
            $show->field('check_result');
            $show->field('phone');
            $show->field('address');
            $show->field('floor');
            $show->field('area_quantity');
            $show->field('remark');
            $show->field('pictures');
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
        return Form::make(new Firm(), function (Form $form) {
            // $form->display('id');
            $form->text('name')->required();
            $form->text('custom_number')->required()
                ->rules(function (Form $form) {
                    // 如果不是编辑状态，则添加字段唯一验证
                    // 可能有bug，id不存在 todo
                    if (!$id = $form->model()->id) {
                        return 'unique:firms,custom_number';
                    }
                    return '';
                }, [
                    // rule
                    'unique' => '自定义编号已存在',
                ]);
            $form->select('system_item_id')->options(SystemItem::all()->pluck('name', 'id'));
            $form->text('head_man')->required();
            $form->mobile('phone', '手机号')->options(['mask' => '99999999999'])->required();
            $form->text('community_name')->required();
            $form->select('check_type')->options(\App\Models\Firm::$formatCheckTypeMaps)->required();
            $form->select('status')->options(\App\Models\Firm::$formatStatusMaps);
            $form->select('check_result')->options(\App\Models\Firm::$formatCheckResultMaps);
            $form->number('area_quantity');
            $form->number('floor');
            $form->text('address');
            $form->text('remark')->default('');
            // $form->text('pictures');
            // $form->display('created_at');
            // $form->display('updated_at');
        });
    }
}
