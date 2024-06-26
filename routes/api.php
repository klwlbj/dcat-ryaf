<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FirmController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\CheckItemController;
use App\Http\Controllers\Api\CheckResultController;

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
    Route::post('getCheckStandard', [CheckItemController::class, 'getCheckStandard']);
    Route::post('getCheckTypeEnterpriseList', [CheckItemController::class, 'getCheckTypeEnterpriseList']);

    Route::post('getEnterpriseList', [FirmController::class, 'getEnterpriseList']);
    Route::post('getCheckStatusList', [FirmController::class, 'getCheckStatusList']);
    Route::post('getEnterprise', [FirmController::class, 'getEnterprise']);
    Route::post('saveEnterprise', [FirmController::class, 'saveEnterprise']);
    Route::post('getCommunityList', [FirmController::class, 'getCommunityList']);
    Route::post('getBaseInfo', [FirmController::class, 'getBaseInfo']);

    Route::post('getCollectInfoList', [ImageController::class, 'getCollectInfoList']);
    Route::post('getCollectImgList', [ImageController::class, 'getCollectImgList']);
    Route::post('getCheckDetailList', [CheckResultController::class, 'getCheckDetailList']);
    Route::post('/uploadImage', [ImageController::class, 'uploadImage']);
    Route::post('/deleteImage', [ImageController::class, 'deleteImage']);

    Route::post('getCheckBaseInfo', [CheckResultController::class, 'getCheckBaseInfo']);
    Route::post('saveCheckResult', [CheckResultController::class, 'saveCheckResult']);
    Route::post('createReport', [CheckResultController::class, 'createReport']);
    Route::post('stopCheck', [CheckResultController::class, 'stopCheck']);
    Route::post('findUserCheckResult', [CheckResultController::class, 'findUserCheckResult']);
    Route::post('findUserCheckEnterprise', [CheckResultController::class, 'findUserCheckEnterprise']);

    Route::post('changeSystemItemId', [UserController::class, 'changeSystemItemId']);
});

Route::post('/getProjectList', [FirmController::class, 'getProjectList']);

Route::post('/login', [UserController::class, 'login'])->middleware('web')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
