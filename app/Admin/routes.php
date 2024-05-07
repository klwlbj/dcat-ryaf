<?php

use Dcat\Admin\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\CommunityController;
use App\Admin\Controllers\CheckReportController;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('users', 'UserController');
    $router->resource('groups', 'GroupController');
    $router->resource('firms', 'FirmController');
    $router->resource('check_items', 'CheckItemController');
    $router->resource('areas', 'AreaController');
    $router->resource('system_items', 'SystemItemController');
    $router->resource('check_results', 'CheckResultController');

    $router->get("check_report/index", [CheckReportController::class, "index"]);
    $router->get("check_report/detail", [CheckReportController::class, "detailView"]);

    $router->get('api/community', [CommunityController::class, 'getList']);
});

// 免登录
Route::group([
    'prefix'    => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
], function (Router $router) {
    $router->post("check_report/info", [CheckReportController::class, "info"]);
    $router->post("check_report/qr_view", [CheckReportController::class, "qrView"]);
    $router->post("check_report/create_rectify_word", [CheckReportController::class, "createWord"]);
    $router->post("check_report/create_hidden_trouble_excel", [CheckReportController::class, "createHiddenTroubleExcel"]);
});
