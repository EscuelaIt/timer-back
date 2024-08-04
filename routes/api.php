<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\GetUserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Country\CountryListController;
use App\Http\Controllers\Country\CountryShowController;
use App\Http\Controllers\Project\ProjectListController;
use App\Http\Controllers\Project\ProjectShowController;
use App\Http\Controllers\Country\CountryStoreController;
use App\Http\Controllers\Project\ProjectStoreController;
use App\Http\Controllers\Category\CategoryListController;
use App\Http\Controllers\Category\CategoryShowController;
use App\Http\Controllers\Country\CountryActionController;
use App\Http\Controllers\Country\CountryUpdateController;
use App\Http\Controllers\Customer\CustomerListController;
use App\Http\Controllers\Customer\CustomerShowController;
use App\Http\Controllers\Interval\IntervalListController;
use App\Http\Controllers\Interval\IntervalOpenController;
use App\Http\Controllers\Interval\IntervalShowController;
use App\Http\Controllers\Project\ProjectUpdateController;
use App\Http\Controllers\Category\CategoryStoreController;
use App\Http\Controllers\Country\CountryDestroyController;
use App\Http\Controllers\Customer\CustomerStoreController;
use App\Http\Controllers\Interval\IntervalCloseController;
use App\Http\Controllers\Project\ProjectDestroyController;
use App\Http\Controllers\BoardGame\BoardGameListController;
use App\Http\Controllers\BoardGame\BoardGameShowController;
use App\Http\Controllers\Category\CategoryUpdateController;
use App\Http\Controllers\Customer\CustomerUpdateController;
use App\Http\Controllers\Interval\IntervalUpdateController;
use App\Http\Controllers\BoardGame\BoardGameStoreController;
use App\Http\Controllers\Category\CategoryDestroyController;
use App\Http\Controllers\Customer\CustomerDestroyController;
use App\Http\Controllers\Interval\IntervalDestroyController;
use App\Http\Controllers\BoardGame\BoardGameActionController;
use App\Http\Controllers\BoardGame\BoardGameAllIdsController;
use App\Http\Controllers\BoardGame\BoardGameUpdateController;
use App\Http\Controllers\BoardGame\BoardGameDestroyController;
use App\Http\Controllers\Interval\UpdateIntervalCategoryController;

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

Route::middleware('auth:sanctum')->get('/auth/user', [GetUserController::class, 'getUser']);


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

Route::prefix('/projects')->middleware('auth:sanctum')->group(function() {
    Route::get('', [ProjectListController::class, 'index']);
    Route::post('', [ProjectStoreController::class, 'store']);
    Route::get('/{id}', [ProjectShowController::class, 'show']);
    Route::put('/{id}', [ProjectUpdateController::class, 'update']);
    Route::delete('/{id}', [ProjectDestroyController::class, 'destroy']);
});

Route::prefix('/categories')->middleware('auth:sanctum')->group(function() {
    Route::get('', [CategoryListController::class, 'index']);
    Route::post('', [CategoryStoreController::class, 'store']);
    Route::get('/{id}', [CategoryShowController::class, 'show']);
    Route::put('/{id}', [CategoryUpdateController::class, 'update']);
    Route::delete('/{id}', [CategoryDestroyController::class, 'destroy']);
});

Route::prefix('/intervals')->middleware('auth:sanctum')->group(function() {
    Route::get('', [IntervalListController::class, 'index']);
    Route::post('', [IntervalOpenController::class, 'store']);
    Route::get('/finalize', [IntervalCloseController::class, 'finalize']);
    Route::get('/{id}', [IntervalShowController::class, 'show']);
    Route::put('/{id}', [IntervalUpdateController::class, 'update']);
    Route::delete('/{id}', [IntervalDestroyController::class, 'destroy']);
    Route::post('/{id}/attach-category', [UpdateIntervalCategoryController::class, 'attachCategory']);
});

Route::prefix('/countries')->group(function() {
    Route::get('/', [CountryListController::class, 'index']);
    Route::post('/', [CountryStoreController::class, 'store']);
    Route::post('/action', [CountryActionController::class , 'handleAction']);
    Route::get('/{id}', [CountryShowController::class, 'show']);
    Route::put('/{id}', [CountryUpdateController::class, 'update']);
    Route::delete('/{id}', [CountryDestroyController::class, 'destroy']);
});


Route::prefix('/board-games')->group(function() {
    Route::get('/', [BoardGameListController::class, 'search']);
    Route::post('/', [BoardGameStoreController::class, 'store']);
    Route::get('/allids', [BoardGameAllIdsController::class , 'allids']);
    Route::post('/action', [BoardGameActionController::class , 'handleAction']);
    Route::get('/{id}', [BoardGameShowController::class, 'show']);
    Route::put('/{id}', [BoardGameUpdateController::class, 'update']);
    Route::delete('/{id}', [BoardGameDestroyController::class, 'destroy']);
});

