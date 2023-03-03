<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Customer\LoginController as CustomerLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuItemController;

//user
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\TransaksiController;

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

    Route::get('menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('menu', [MenuController::class, 'store'])->name('menu.store');
    Route::get('menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::patch('menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    Route::get('menu-items', [MenuItemController::class, 'index'])->name('menu-item.index');
    Route::get('menu-items/create', [MenuItemController::class, 'create'])->name('menu-item.create');
    Route::post('menu-items', [MenuItemController::class, 'store'])->name('menu-item.store');
    Route::get('menu-items/{id}/edit', [MenuItemController::class, 'edit'])->name('menu-item.edit');
    Route::patch('menu-items/{id}', [MenuItemController::class, 'update'])->name('menu-item.update');
    Route::delete('menu-items/{id}', [MenuItemController::class, 'destroy'])->name('menu-item.destroy');

    Route::get('transaksi/booking', [TransaksiController::class, 'index'])->name('booking.user');
    Route::post('transaksi/booking', [TransaksiController::class, 'storeAccept'])->name('booking.storeAccept');
    Route::post('transaksi/booking/reject', [TransaksiController::class, 'storeReject'])->name('booking.storeReject');
    Route::get('historyAdmnin', [TransaksiController::class, 'history'])->name('historyAdmin');

    Route::get('logoutaksi', [LoginController::class, 'logoutaksi'])->name('logoutaksi');
});


Route::group(['middleware' => 'customer', 'prefix' => 'customer'], function () {
    // Route::get('/', function () {
    //     return 'customer';
    // })->name('customer');

    Route::get('item', [TransactionController::class, 'transaksi'])->name('item');
    Route::get('transaksi', [TransactionController::class, 'index'])->name('customer');
    Route::post('transaksi', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('booking', [TransactionController::class, 'booking'])->name('booking');
    Route::get('history', [TransactionController::class, 'history'])->name('history');

    Route::get('logoutaksi', [CustomerLoginController::class, 'logoutaksi'])->name('logoutaksicustomer');
});

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('register', [LoginController::class, 'register'])->name('register');
Route::get('forgot', [LoginController::class, 'viewForgot'])->name('forgot');
Route::post('forgot', [LoginController::class, 'forgot'])->name('forgotAksi');
Route::post('loginaksi', [LoginController::class, 'loginaksi'])->name('loginaksi');
Route::get('view-verify', [LoginController::class, 'token'])->name('view-verify');
Route::get('verify-token', [LoginController::class, 'verifyToken'])->name('verify-token');
Route::post('verify-token', [LoginController::class, 'updatePassword'])->name('verify-token');

Route::get('booking/{id}/detail', [TransactionController::class, 'detail'])->name('detail');
