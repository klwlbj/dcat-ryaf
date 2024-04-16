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
});
