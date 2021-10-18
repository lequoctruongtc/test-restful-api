<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Api\LoanPaymentController;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'v1',
], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['prefix' => 'loans'], function () {
            Route::get('/', [LoanController::class, 'index']);
            Route::get('{id}', [LoanController::class, 'show']);
            Route::post('/', [LoanController::class, 'store']);
        });
        Route::group(['prefix' => 'loan-payments'], function () {
            Route::get('/', [LoanPaymentController::class, 'index']);
            Route::get('{id}', [LoanPaymentController::class, 'show']);
            Route::patch('{id}/pay', [LoanPaymentController::class, 'pay']);
        });
    });
});

