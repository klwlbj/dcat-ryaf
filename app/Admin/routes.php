<?php

use Dcat\Admin\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

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

    Route::any("check_report/index", "CheckReportController@index");
    Route::any("check_report/detail", "CheckReportController@detailView");
    Route::any("check_report/lists", "CheckReportController@getList");

});

#免登录
Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
], function (Router $router) {
    Route::any("check_report/info", "CheckReportController@info");
    Route::any("check_report/qr_view", "CheckReportController@qrView");
    Route::any("check_report/create_rectify_word", "CheckReportController@createRectifyWord");
    Route::any("check_report/create_hidden_trouble_excel", "CheckReportController@createHiddenTroubleExcel");
});
