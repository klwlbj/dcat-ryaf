<?php

namespace App\Http\Controllers\Web;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {
        return view('web/index');
    }

    public function enterprise(){
        return view('web/enterprise');

    }

    public function user(){
        return view('web/user');

    }

    public function baseInfo(){
        return view('web/baseInfo');

    }

    public function checkStandard(){
        return view('web/checkStandard');

    }

    public function checkResult(){
        return view('web/checkResult');

    }

}
