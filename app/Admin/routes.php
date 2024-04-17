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

    Route::any("report/index", "ReportController@index");
    Route::any("report/detail", "ReportController@detailView");
    Route::any("report/lists", "ReportController@getList");

});

#免登录
Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
], function (Router $router) {
    Route::any("report/info", "ReportController@info");
    Route::any("report/qr_view", "ReportController@qrView");
    Route::any("report/create_word", "ReportController@createWord");
});
