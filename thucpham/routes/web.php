<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\loginController;
use App\Http\Controllers\Admin\mainController;

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
Route::get('/admin/login', [loginController::class, 'index'])->name('login_admin');//name :tên router
Route::post('/admin/login/check', [loginController::class, 'check'])->name('check_login_admin');
Route::get('/admin', [mainController::class, 'index'])->name('admin');//name :tên router

