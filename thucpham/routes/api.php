<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\productApiController;
use App\Http\Controllers\API\categoryApiController;
use App\Http\Controllers\API\brandApiController;
use App\Http\Controllers\API\userApiController;
use App\Http\Controllers\API\billApiController;
use App\Http\Controllers\API\billDetailApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Thong tin san pham API
Route::apiResource('product', productApiController::class);
Route::get('product/category/{idloai?}', [productApiController::class, 'getByCategory']);
Route::get('product/search/{name?}', [productApiController::class, 'searchProduct']);


//Thong tin loai san pham API
Route::apiResource('category', categoryApiController::class);
Route::get('category/name/{ten?}', [categoryApiController::class, 'getByNameCategory']);
Route::get('category/name-father/{cha?}', [categoryApiController::class, 'getByNameFatherCategory']);
Route::post('category/update/{id?}', [categoryApiController::class, 'update']);
//Thong tin thuong hieu API
Route::apiResource('brand', brandApiController::class);
Route::get('brand/name/{ten?}', [brandApiController::class, 'getByNameBrand']);

//Thong tin tai khoan API
Route::apiResource('user', userApiController::class);
Route::get('user/email/{email?}', [userApiController::class, 'getByEmail']);
Route::post('user/phone', [userApiController::class, 'getAccByPhone']);

Route::post('user/checklogin', [userApiController::class, 'login'])->name('check_login_user');

//Thong tin don hang API
Route::apiResource('bill', billApiController::class);
Route::get('bill/id-customer/{idkhachhang?}', [billApiController::class, 'getByIDCustomer']);


Route::get('bill/cart/{id?}', [userApiController::class, 'getCart']);

//Thong tin chi tiet don hang API
Route::apiResource('bill-detail', billDetailApiController::class);
Route::get('bill-detail/id-bill/{idhoadon?}', [billDetailApiController::class, 'getByIDBill']);
Route::post('bill-detail/update/{idsanpham?}/{iddonhang?}', [billDetailApiController::class, 'update']);
Route::get('bill-detail/id-product/{idsanpham?}', [billDetailApiController::class, 'getByIDProduct']);


// Route::get('abc/{id?}', [billApiController::class, 'getProductByBillId']);
Route::get('user/history/{id?}', [userApiController::class, 'getOrderByCustomerId']);
