<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Web\HomeController;

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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/web/index', [HomeController::class, 'index']);
    Route::get('/web/enterprise', [HomeController::class, 'enterprise']);
    Route::get('/web/enterpriseList', [HomeController::class, 'enterpriseList']);
    Route::get('/web/enterpriseInfo', [HomeController::class, 'enterpriseInfo']);

    Route::get('/web/user', [HomeController::class, 'user']);
    Route::get('/web/baseInfo', [HomeController::class, 'baseInfo']);
    Route::get('/web/checkStandard', [HomeController::class, 'checkStandard']);
    Route::get('/web/checkStandardTable', [HomeController::class, 'checkStandardTable']);
    Route::get('/web/collectInfo', [HomeController::class, 'collectInfo']);
    Route::get('/web/logout', [HomeController::class, 'logout']);
    Route::get('/web/checkDetail/check', [HomeController::class, 'checkDetail']);
});
Route::get('/public/xf/upload/{year}/{month}/{filename}', function ($year, $month, $filename) {
    // $path = public_path($directory . '/' . $filename);

    $path = Storage::disk('public')->path('xf/upload/' . $year . '/' . $month . '/' . $filename);
    // 检查文件是否存在
    if (file_exists($path)) {
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    abort(404);
});
Route::get('/web/login', [HomeController::class, 'login']);
