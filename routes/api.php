<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    AttendanceController,
    SalaryController,
    RoleController
};

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [AuthController::class, 'index']);
    Route::get('user/{id}', [AuthController::class, 'show']);
    Route::patch('user/{id}', [AuthController::class, 'update']);
    Route::delete('user/{id}', [AuthController::class, 'destroy']);
    Route::apiResource('/attendance', AttendanceController::class);
    Route::apiResource('/salary', SalaryController::class);
    Route::apiResource('/roles', RoleController::class);
});
