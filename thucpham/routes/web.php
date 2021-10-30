<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\loginController;
use App\Http\Controllers\Admin\mainController;
use App\Http\Controllers\Admin\loaispController;
use App\Http\Controllers\admin\thuonghieuController;
use App\Http\Controllers\admin\taikhoanController;
use App\Http\Controllers\Admin\sanPhamController;
use App\Http\Controllers\admin\nhapHangController;
use App\Http\Controllers\admin\donHangController;

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
Route::get('/admin/main', [mainController::class, 'index'])->name('admin');//name :tên router

Route::prefix('admin/hanghoa')->group(function () {
    Route::prefix('loaisp')->group(function () {
        Route::get('/', [LoaispController::class, 'index'])->name('loaisp');
        Route::get('add', [LoaispController::class, 'add']);
        Route::post('add', [LoaispController::class, 'store']);
        Route::get('edit/{loaisp}', [LoaispController::class, 'edit']);
        Route::post('edit/{loaisp}', [LoaispController::class, 'update']);
        Route::delete('delete', [LoaispController::class, 'delete']);
    });
    Route::prefix('thuonghieu')->group(function () {
        Route::get('/', [thuonghieuController::class, 'index'])->name('thuonghieu');
        Route::get('add', [thuonghieuController::class, 'add']);
        Route::post('add', [thuonghieuController::class, 'store']);
        Route::get('edit/{thuonghieu}', [thuonghieuController::class, 'edit']);
        Route::post('edit/{thuonghieu}', [thuonghieuController::class, 'update']);
        Route::delete('delete', [thuonghieuController::class, 'delete']);
    });
    Route::prefix('sanpham')->group(function () {
        Route::get('/', [sanPhamController::class, 'index'])->name('sanpham');
        Route::get('add', [sanPhamController::class, 'add']);
        Route::post('add', [sanPhamController::class, 'store']);
        Route::get('edit/{sanpham}', [sanPhamController::class, 'edit']);
        Route::post('edit/{sanpham}', [sanPhamController::class, 'update']);
        Route::delete('delete', [sanPhamController::class, 'delete']);
    });

});
Route::prefix('admin/doitac')->group(function () {
    Route::get('/{loai}', [taikhoanController::class, 'index'])->name('taikhoan');
    Route::get('chitiet/{taikhoan}', [taikhoanController::class, 'chitiet']);
});
Route::prefix('admin/hoadon')->group(function () {
    Route::prefix('nhap')->group(function () {
        Route::get('/',[nhapHangController::class,'index'])->name('hoadonnhap');
        Route::get('add',[nhapHangController::class,'add']);
        Route::post('add',[nhapHangController::class,'store']);
        Route::get('edit/{hoadonnhap}',[nhapHangController::class,'chitiet_add'])->name('edit_nhap');
        Route::post('edit/{hoadonnhap}',[nhapHangController::class,'update']);
        Route::any('save/{hoadonnhap}',[nhapHangController::class,'save']);
        Route::any('delete/{hoadonnhap}',[nhapHangController::class,'delete']);
        Route::any('destroy/{hoadonnhap}',[nhapHangController::class,'destroy']);
        Route::get('chitiet/{hoadonnhap}',[nhapHangController::class,'chitiet']);
    });
    Route::prefix('ban')->group(function () {
        Route::get('/{loai}',[donHangController::class,'index'])->name('hoadonban');
        Route::get('chitiet/{hoadonban}',[donHangController::class,'chitiet']);
        Route::get('chitiet/duyet/{hoadonban}',[donHangController::class,'duyet']);
        Route::get('chitiet/giao/{hoadonban}',[donHangController::class,'giao']);
    });
});
