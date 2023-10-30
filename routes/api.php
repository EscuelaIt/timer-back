<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\CustomerListController;
use App\Http\Controllers\Customer\CustomerShowController;
use App\Http\Controllers\Customer\CustomerStoreController;
use App\Http\Controllers\Customer\CustomerUpdateController;
use App\Http\Controllers\Customer\CustomerDestroyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/auth/register', [RegisterController::class, 'registerUser']);
Route::post('/auth/login', [LoginController::class, 'loginUser']);
Route::middleware('auth:sanctum')->get('/auth/logout', [LogoutController::class, 'logoutUser']);

Route::prefix('/customers')->middleware('auth:sanctum')->group(function() {
    Route::get('', [CustomerListController::class, 'index']);
    Route::post('', [CustomerStoreController::class, 'store']);
    Route::get('/{id}', [CustomerShowController::class, 'show']);
    Route::put('/{id}', [CustomerUpdateController::class, 'update']);
    Route::delete('/{id}', [CustomerDestroyController::class, 'destroy']);
});