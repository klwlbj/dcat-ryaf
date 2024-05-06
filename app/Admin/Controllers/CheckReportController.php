<?php

namespace App\Admin\Controllers;

use App\Logic\ResponseLogic;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Content;
use App\Logic\Admin\CheckReportLogic;
use App\Logic\Word\CheckReportWordLogic;
use Illuminate\Support\Facades\Validator;
use App\Logic\Excel\HiddenTroubleExcelLogic;
use Dcat\Admin\Http\Controllers\AdminController;

class CheckReportController extends AdminController
{
    public function index(Content $content): Content
    {
        return $content->header('检查报告')->body(admin_view('admin.checkReport.index'));
    }

    public function detailView(Content $content): Content
    {
        return $content->header('报告详情')->body(admin_view('admin.checkReport.detail'));
    }

    public function getList(Request $request): \Illuminate\Http\JsonResponse
    {
        $params = $request->all();

        return CheckReportLogic::getInstance()->getList($params);
    }

    public function info(Request $request): \Illuminate\Http\JsonResponse
    {
        $params = $request->all();

        $validate = Validator::make($params, [
            'uuid' => 'required',
        ], [
            'uuid.required' => '报告编号不能为空',
        ]);

        if ($validate->fails()) {
            return ResponseLogic::apiErrorResult($validate->errors()->first());
        }

        return CheckReportLogic::getInstance()->getDetail($params);
    }

    public function qrView(Request $request)
    {
        return view('admin.checkReport.qr');
    }

    public function createWord(Request $request)
    {
        $params = $request->all();

        $validate = Validator::make($params, [
            'uuid' => 'required',
        ], [
            'uuid.required' => '报告编号不能为空',
        ]);

        if ($validate->fails()) {
            return ResponseLogic::apiErrorResult($validate->errors()->first());
        }
        return CheckReportWordLogic::getInstance()->createWord($params);
    }

    public function createHiddenTroubleExcel(Request $request)
    {
        $params = $request->all();
        return HiddenTroubleExcelLogic::getInstance()->createExcel($params);
    }
}
