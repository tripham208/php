<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\productApiController;
use App\Http\Controllers\API\categoryApiController;
use App\Http\Controllers\API\brandApiController;
use App\Http\Controllers\API\userApiController;

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

//Thong tin loai san pham API
Route::apiResource('category', categoryApiController::class);
Route::get('category/name/{ten?}', [categoryApiController::class, 'getByNameCategory']);
Route::get('category/name-father/{cha?}', [categoryApiController::class, 'getByNameFatherCategory']);

//Thong tin thuong hieu API
Route::apiResource('brand', brandApiController::class);
Route::get('brand/name/{ten?}', [brandApiController::class, 'getByNameBrand']);

//Thong tin tai khoan API
Route::apiResource('user', userApiController::class);
Route::get('user/email/{email?}', [userApiController::class, 'getByEmail']);