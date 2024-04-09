<?php

namespace App\Http\Controllers\Web;

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

    public function enterpriseList()
    {
        return view('web/enterpriseList');
    }

    public function enterpriseInfo(Request $request)
    {
        $number = $request->get('number');
        return view('web/enterpriseInfo', ['number' => $number]);
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
}
