<?php

use App\Http\Controllers\Api\FirmController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CheckStandardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('getCheckStandard', [CheckStandardController::class, 'getCheckStandard']);
Route::post('getCheckTypeEnterpriseList', [CheckStandardController::class, 'getCheckTypeEnterpriseList']);
Route::post('getEnterpriseList', [FirmController::class, 'getEnterpriseList']);
Route::post('getCheckStatusList', [FirmController::class, 'getCheckStatusList']);
Route::post('getEnterprise', [FirmController::class, 'getEnterprise']);
Route::post('login', [UserController::class, 'login']);
