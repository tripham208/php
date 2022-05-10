<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\loginController;
use App\Http\Controllers\Admin\mainController;
use App\Http\Controllers\Admin\categoryController;
use App\Http\Controllers\admin\branchController;
use App\Http\Controllers\admin\accountController;
use App\Http\Controllers\Admin\productController;
use App\Http\Controllers\admin\nhapHangController;
use App\Http\Controllers\admin\billController;

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
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/main', [mainController::class, 'index'])->name('admin');//name :tên router

    Route::prefix('admin/hanghoa')->group(function () {
        Route::prefix('loaisp')->group(function () {
            Route::get('/', [categoryController::class, 'index'])->name('loaisp');
            Route::get('add', [categoryController::class, 'add']);
            Route::post('add', [categoryController::class, 'store']);
            Route::get('edit/{loaisp}', [categoryController::class, 'edit']);
            Route::post('edit/{loaisp}', [categoryController::class, 'update']);
            Route::delete('delete', [categoryController::class, 'delete']);
        });
        Route::prefix('thuonghieu')->group(function () {
            Route::get('/', [branchController::class, 'index'])->name('thuonghieu');
            Route::get('add', [branchController::class, 'add']);
            Route::post('add', [branchController::class, 'store']);
            Route::get('edit/{thuonghieu}', [branchController::class, 'edit']);
            Route::post('edit/{thuonghieu}', [branchController::class, 'update']);
            Route::delete('delete', [branchController::class, 'delete']);
        });
        Route::prefix('sanpham')->group(function () {
            Route::get('/', [productController::class, 'index'])->name('sanpham');
            Route::get('add', [productController::class, 'add']);
            Route::post('add', [productController::class, 'store']);
            Route::get('chitiet/{sanpham}', [productController::class, 'chitiet']);
            Route::get('edit/{sanpham}', [productController::class, 'edit']);
            Route::post('edit/{sanpham}', [productController::class, 'update']);
            Route::delete('delete', [productController::class, 'delete']);
        });

    });
    Route::prefix('admin/doitac')->group(function () {
        Route::get('/{loai}', [accountController::class, 'index'])->name('taikhoan');
        Route::get('chitiet/{taikhoan}', [accountController::class, 'chitiet']);
    });
    Route::prefix('admin/hoadon')->group(function () {
        Route::prefix('nhap')->group(function () {
            Route::get('/', [nhapHangController::class, 'index'])->name('hoadonnhap');
            Route::get('add', [nhapHangController::class, 'add']);
            Route::post('add', [nhapHangController::class, 'store']);
            Route::get('edit/{hoadonnhap}', [nhapHangController::class, 'chitiet_add'])->name('edit_nhap');
            Route::post('edit/{hoadonnhap}', [nhapHangController::class, 'update']);
            Route::any('save/{hoadonnhap}', [nhapHangController::class, 'save']);
            Route::any('delete/{hoadonnhap}', [nhapHangController::class, 'delete']);
            Route::any('destroy/{hoadonnhap}', [nhapHangController::class, 'destroy']);
            Route::get('chitiet/{hoadonnhap}', [nhapHangController::class, 'chitiet']);
        });
        Route::prefix('ban')->group(function () {
            Route::get('/{loai}', [billController::class, 'index'])->name('hoadonban');
            Route::get('chitiet/{hoadonban}', [billController::class, 'chitiet']);
            Route::get('chitiet/duyet/{hoadonban}', [billController::class, 'duyet']);
            Route::get('chitiet/giao/{hoadonban}', [billController::class, 'giao']);
        });
    });
});
