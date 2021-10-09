<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\loginController;
use App\Http\Controllers\Admin\mainController;
use App\Http\Controllers\Admin\loaispController;
use App\Http\Controllers\admin\thuonghieuController;

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

Route::prefix('admin/hanghoa')->group(function () {
    Route::prefix('loaisp')->group(function () {
        Route::get('/',[LoaispController::class,'index'])->name('loaisp');
        Route::get('add',[LoaispController::class,'add']);
        Route::post('add',[LoaispController::class,'store']);
        Route::get('edit/{loaisp}',[LoaispController::class,'edit']);
        Route::post('edit/{loaisp}',[LoaispController::class,'update']);
        Route::delete('delete',[LoaispController::class,'delete']);
    });
    Route::prefix('thuonghieu')->group(function () {
        Route::get('/',[thuonghieuController::class,'index'])->name('thuonghieu');
        Route::get('add',[thuonghieuController::class,'add']);
        Route::post('add',[thuonghieuController::class,'store']);
        Route::get('edit/{thuonghieu}',[thuonghieuController::class,'edit']);
        Route::post('edit/{thuonghieu}',[thuonghieuController::class,'update']);
        Route::delete('delete',[thuonghieuController::class,'delete']);
    });

});
