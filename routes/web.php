<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Customer\LoginController as CustomerLoginController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('logoutaksi', [LoginController::class, 'logoutaksi'])->name('logoutaksi');
});


Route::group(['middleware' => 'customer', 'prefix' => 'customer'], function () {
    Route::get('/', function () {
        return 'customer';
    })->name('customer');
    Route::get('logoutaksi', [CustomerLoginController::class, 'logoutaksi'])->name('logoutaksicustomer');
});

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('forgot', [LoginController::class, 'viewForgot'])->name('forgot');
Route::post('forgot', [LoginController::class, 'forgot'])->name('forgotAksi');
Route::post('loginaksi', [LoginController::class, 'loginaksi'])->name('loginaksi');
Route::get('view-verify', [LoginController::class, 'token'])->name('view-verify');
Route::get('verify-token', [LoginController::class, 'verifyToken'])->name('verify-token');
Route::post('verify-token', [LoginController::class, 'updatePassword'])->name('verify-token');
