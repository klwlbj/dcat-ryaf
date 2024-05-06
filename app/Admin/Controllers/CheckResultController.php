<?php

namespace App\Admin\Controllers;

use App\Models\Firm;
use Dcat\Admin\Grid;
use App\Models\SystemItem;
use App\Admin\Repositories\CheckResult;
use Dcat\Admin\Http\Controllers\AdminController;

class CheckResultController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CheckResult(['firm']), function (Grid $grid) {
            $grid->column('id', '序号')->sortable();
            $grid->column('check_result', '报告详情')->display('报告详情')->link(function () {
                return admin_url('/check_report/detail?uuid=' . $this->report_code);
            });
            $grid->column('check_result_doc', '整改通知书')->display('整改通知书')->link(function () {
                return admin_url('/check_report/create_rectify_word?uuid=' . $this->report_code);
            });
            // $grid->column('report_code');
            $grid->column('status')->using(\App\Models\CheckResult::$formatStatusMaps);
            $grid->column('firm.custom_number', '自定义编号');
            $grid->column('firm.name', '企业名称');
            $grid->column('firm.address', '企业地址');
            $grid->column('firm.head_man', '负责人');
            $grid->column('firm.phone', '联系方式');
            $grid->column('firm.status', '企业状态')->using(Firm::$formatStatusMaps);
            $grid->column('total_point');
            // $grid->column('created_at');
            $grid->column('updated_at', '检查时间')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局
                $filter->panel();
                $filter->expand();
                $filter->equal('firm.system_item_id', '所属项目')->select(SystemItem::all()->pluck('name', 'id'))->width(3);
                $filter->like('firm.name', '企业名称')->width(3);
                $filter->like('firm.custom_number', '企业编号')->width(2);
                $filter->equal('firm.check_type', '检查类型')->select(Firm::$formatCheckTypeMaps)->width(2);
                $filter->equal('firm.status', '检查状态')->select(Firm::$formatStatusMaps)->width(2);
            });
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableActions();
            $grid->disableBatchDelete();
        });
    }
}
