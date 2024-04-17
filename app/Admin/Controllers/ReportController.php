<?php

namespace App\Admin\Controllers;

use App\Logic\ResponseLogic;
use App\Logic\Word\CheckReportWordLogic;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Content;
use App\Logic\Admin\ReportLogic;
use Illuminate\Support\Facades\Validator;
use Dcat\Admin\Http\Controllers\AdminController;

class ReportController extends AdminController
{
    public function index(Content $content): Content
    {
        return $content->header('检查报告')->body(admin_view('admin.checkReport.index'));
    }

    public function detailView(Request $request,Content $content): Content
    {
        return $content->header('报告详情')->body(admin_view('admin.checkReport.detail'));
    }

    public function getList(Request $request): \Illuminate\Http\JsonResponse
    {
        $params = $request->all();

        return ReportLogic::getInstance()->getList($params);
    }

    public function info(Request $request): \Illuminate\Http\JsonResponse
    {
        $params = $request->all();

        $validate = Validator::make($params, [
            'id' => 'required',
        ], [
            'id.required' => '报告id不能为空',
        ]);

        if($validate->fails()) {
            return ResponseLogic::apiErrorResult($validate->errors()->first());
        }

        return ReportLogic::getInstance()->getDetail($params);
    }

    public function qrView(Request $request){
        return view('admin.checkReport.qr');
    }

    public function createWord(Request $request){
        return CheckReportWordLogic::getInstance()->createWord([]);
    }
}
