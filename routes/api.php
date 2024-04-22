<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FirmController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\checkResultController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::post('getCheckStandard', [CheckStandardController::class, 'getCheckStandard']);
    Route::post('getCheckTypeEnterpriseList', [CheckStandardController::class, 'getCheckTypeEnterpriseList']);
    Route::post('getEnterpriseList', [FirmController::class, 'getEnterpriseList']);
    Route::post('getCheckStatusList', [FirmController::class, 'getCheckStatusList']);
    Route::post('getEnterprise', [FirmController::class, 'getEnterprise']);
    Route::post('saveEnterprise', [FirmController::class, 'saveEnterprise']);

    Route::post('getCollectInfoList', [ImageController::class, 'getCollectInfoList']);
    Route::post('getCollectImgList', [ImageController::class, 'getCollectImgList']);
    Route::post('getCheckDetailList', [checkResultController::class, 'getCheckDetailList']);
    Route::post('getCheckBaseInfo', [checkResultController::class, 'getCheckBaseInfo']);
    Route::post('saveCheckResult', [checkResultController::class, 'saveCheckResult']);
    Route::post('createReport', [checkResultController::class, 'createReport']);
    Route::post('stopCheck', [checkResultController::class, 'stopCheck']);

    Route::post('/uploadImage', [ImageController::class, 'uploadImage']);
    Route::post('/deleteImage', [ImageController::class, 'deleteImage']);
    Route::post('changeSystemItemId', [UserController::class, 'changeSystemItemId']);
});

Route::post('/getProjectList', [FirmController::class, 'getProjectList']);

Route::post('/login', [UserController::class, 'login'])->middleware('web')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
