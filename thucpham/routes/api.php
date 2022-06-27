<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\CategoryApiController;
use App\Http\Controllers\API\brandApiController;
use App\Http\Controllers\API\UserApiController;
use App\Http\Controllers\API\BillApiController;
use App\Http\Controllers\API\BillDetailApiController;

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
Route::apiResource('product', ProductApiController::class);
Route::get('product/category/{idloai?}', [ProductApiController::class, 'getByCategory']);
Route::get('product/search/{name?}', [ProductApiController::class, 'searchProduct']);


//Thong tin loai san pham API
Route::apiResource('category', CategoryApiController::class);
Route::get('category/name/{ten?}', [CategoryApiController::class, 'getByNameCategory']);
Route::get('category/name-father/{cha?}', [CategoryApiController::class, 'getByNameFatherCategory']);
Route::post('category/update/{id?}', [CategoryApiController::class, 'update']);
//Thong tin thuong hieu API
Route::apiResource('brand', brandApiController::class);
Route::get('brand/name/{ten?}', [brandApiController::class, 'getByNameBrand']);

//Thong tin tai khoan API
Route::apiResource('user', UserApiController::class);
Route::get('user/email/{email?}', [UserApiController::class, 'getByEmail']);
Route::post('user/phone', [UserApiController::class, 'getAccByPhone']);
Route::post('user/checklogin', [UserApiController::class, 'login'])->name('check_login_user');

//Thong tin don hang API
Route::apiResource('bill', BillApiController::class);
Route::get('bill/id-customer/{idCustomer?}', [BillApiController::class, 'getByIDCustomer']);


Route::get('bill/cart/{id?}', [UserApiController::class, 'getCart']);

//Thong tin chi tiet don hang API
Route::apiResource('bill-detail', BillDetailApiController::class);
Route::get('bill-detail/id-bill/{idhoadon?}', [BillDetailApiController::class, 'getByIDBill']);
Route::post('bill-detail/update/{idsanpham?}/{iddonhang?}', [BillDetailApiController::class, 'update']);
Route::get('bill-detail/id-product/{idsanpham?}', [BillDetailApiController::class, 'getByIDProduct']);


// Route::get('abc/{id?}', [billApiController::class, 'getProductByBillId']);
Route::get('user/history/{id?}', [UserApiController::class, 'getOrderByCustomerId']);
