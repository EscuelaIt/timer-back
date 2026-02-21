<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('login');

// Password reset view route
Route::get('/password/reset/{token}', [PasswordResetController::class, 'show'])->name('password.reset');

