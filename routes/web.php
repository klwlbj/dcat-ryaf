<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/web/index', [\App\Http\Controllers\Web\HomeController::class, 'index']);
Route::get('/web/enterprise', [\App\Http\Controllers\Web\HomeController::class, 'enterprise']);
Route::get('/web/enterpriseList', [\App\Http\Controllers\Web\HomeController::class, 'enterpriseList']);
Route::get('/web/enterpriseInfo', [\App\Http\Controllers\Web\HomeController::class, 'enterpriseInfo']);
Route::get('/web/user', [\App\Http\Controllers\Web\HomeController::class, 'user']);
Route::get('/web/baseInfo', [\App\Http\Controllers\Web\HomeController::class, 'baseInfo']);
Route::get('/web/checkStandard', [\App\Http\Controllers\Web\HomeController::class, 'checkStandard']);
Route::get('/web/checkStandardTable', [\App\Http\Controllers\Web\HomeController::class, 'checkStandardTable']);
Route::get('/web/login', [\App\Http\Controllers\Web\HomeController::class, 'login']);


Route::post('login', [UserController::class, 'login'])->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);;

