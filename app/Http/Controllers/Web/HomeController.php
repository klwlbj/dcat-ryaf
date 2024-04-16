<?php

namespace App\Http\Controllers\Web;

use App\Models\CheckResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('web/index');
    }

    public function enterprise()
    {
        return view('web/enterprise');
    }

    public function enterpriseList(Request $request)
    {
        $typeId = $request->get('typeId');

        return view('web/enterpriseList', ['typeId' => $typeId]);
    }

    public function enterpriseInfo(Request $request)
    {
        $uuid = $request->get('uuid');
        // 查询最近一条检查记录

        $reportCode = CheckResult::where('firm_id', $uuid)->orderBy('id', 'desc')->value('report_code') ?? '';
        $isCheck    = !empty($reportCode) ? 1 : 0;
        return view('web/enterpriseInfo', ['uuid' => $uuid, 'reportCode' => $reportCode, 'isCheck' => $isCheck]);
    }

    public function user()
    {
        return view('web/user');
    }

    public function baseInfo()
    {
        return view('web/baseInfo');
    }

    public function checkStandard()
    {
        return view('web/checkStandard');
    }

    public function checkStandardTable(Request $request)
    {
        $typeId = $request->get('typeId');
        return view('web/checkStandardTable', ['typeId' => $typeId]);
    }

    public function login()
    {
        return view('web/login');
    }

    public function collectInfo()
    {
        return view('web/collectInfo');
    }

    public function checkDetail(Request $request)
    {
        $uuid       = $request->get('uuid');
        $reportCode = $request->get('reportCode');
        if (empty($reportCode)) {
            $reportCode = CheckResult::where('firm_id', $uuid)
                ->where('status', CheckResult::STATUS_UNSAVED)
                ->value('report_code');
            if (empty($reportCode)) {
                $reportCode = 'new';
            }
        }
        return view('web/checkDetail', ['uuid' => $uuid, 'reportCode' => $reportCode]);
    }
}
