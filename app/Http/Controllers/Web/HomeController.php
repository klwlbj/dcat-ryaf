<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\CheckResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;

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
        $userId       = app('user_id') ?? '';
        $systemItemId = app('system_item_id') ?? '';
        $user         = User::with('group')->find($userId);

        return view('web/user', ['user' => $user, 'systemItemId' => $systemItemId]);
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

    public function checkResult()
    {
        return view('web/checkResult');
    }

    public function userCheckResult(Request $request)
    {
        $phone = $request->get('checkUser');
        $reportTime = $request->get('reportTime');
        return view('web/userCheckResult', ['phone'=>  $phone, 'reportTime' => $reportTime]);
    }

    /**
     * 用户退出登录
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $token = Cookie::get('auth_token', '');
        Redis::del('auth_token:' . $token);

        return redirect('/web/login');
    }

    public function collectInfo(Request $request)
    {
        $uuid = $request->input('uuid');
        return view('web/collectInfo', ['uuid' => $uuid]);
    }

    public function checkDetail(Request $request)
    {
        $uuid       = $request->get('uuid');
        $reportCode = $request->get('reportCode');
        if ($reportCode != 'new') {
            // 重新找最新report_code，不以前端传来为准
            $reportCode = CheckResult::where('firm_id', $uuid)
                ->where('status', CheckResult::STATUS_UNSAVED)
                ->orderBy('created_at', 'desc')
                ->value('report_code') ?? 'new';
        }
        return view('web/checkDetail', ['uuid' => $uuid, 'reportCode' => $reportCode]);
    }
}
