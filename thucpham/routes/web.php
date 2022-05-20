<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\branchController;
use App\Http\Controllers\admin\AccountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\admin\ImportProductController;
use App\Http\Controllers\admin\BillController;

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

    Route::get('/admin/login', [LoginController::class, 'index'])->name('login_admin');//name :tên router
    Route::post('/admin/login/check', [LoginController::class, 'check'])->name('check_login_admin');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/main', [MainController::class, 'index'])->name('admin');//name :tên router

    Route::prefix('admin/hanghoa')->group(function () {
        Route::prefix('typeProduct')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('typeProduct');
            Route::get('add', [CategoryController::class, 'add']);
            Route::post('add', [CategoryController::class, 'store']);
            Route::get('edit/{typeProduct}', [CategoryController::class, 'edit']);
            Route::post('edit/{typeProduct}', [CategoryController::class, 'update']);
            Route::delete('delete', [CategoryController::class, 'delete']);
        });
        Route::prefix('branch')->group(function () {
            Route::get('/', [branchController::class, 'index'])->name('branch');
            Route::get('add', [branchController::class, 'add']);
            Route::post('add', [branchController::class, 'store']);
            Route::get('edit/{branch}', [branchController::class, 'edit']);
            Route::post('edit/{branch}', [branchController::class, 'update']);
            Route::delete('delete', [branchController::class, 'delete']);
        });
        Route::prefix('product')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('product');
            Route::get('add', [ProductController::class, 'add']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('chitiet/{product}', [ProductController::class, 'detail']);
            Route::get('edit/{product}', [ProductController::class, 'edit']);
            Route::post('edit/{product}', [ProductController::class, 'update']);
            Route::delete('delete', [ProductController::class, 'delete']);
        });

    });
    Route::prefix('admin/doitac')->group(function () {
        Route::get('/{loai}', [AccountController::class, 'index'])->name('account');
        Route::get('chitiet/{account}', [AccountController::class, 'detail']);
    });
    Route::prefix('admin/hoadon')->group(function () {
        Route::prefix('nhap')->group(function () {
            Route::get('/', [ImportProductController::class, 'index'])->name('importProduct');
            Route::get('add', [ImportProductController::class, 'add']);
            Route::post('add', [ImportProductController::class, 'store']);
            Route::get('edit/{importProduct}', [ImportProductController::class, 'addDetail'])->name('edit_nhap');
            Route::post('edit/{importProduct}', [ImportProductController::class, 'update']);
            Route::any('save/{importProduct}', [ImportProductController::class, 'save']);
            Route::any('delete/{importProduct}', [ImportProductController::class, 'delete']);
            Route::any('destroy/{importProduct}', [ImportProductController::class, 'destroy']);
            Route::get('chitiet/{importProduct}', [ImportProductController::class, 'detail']);
        });
        Route::prefix('ban')->group(function () {
            Route::get('/{loai}', [BillController::class, 'index'])->name('hoadonban');
            Route::get('chitiet/{order}', [BillController::class, 'detail']);
            Route::get('chitiet/duyet/{order}', [BillController::class, 'duyet']);
            Route::get('chitiet/giao/{order}', [BillController::class, 'giao']);
        });
    });
});
