<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\sanpham;

class sanPhamAPIController extends Controller
{
    public function product()
    {
        return response()->json(sanpham::get(), 200);
    }
    public function productByID($id)
    {
        return response()->json(sanpham::find($id), 200);
    }
    public function postProduct($request)
    {
        $product = sanpham::create($request->all());
        return response()->json($product, 201);
    }
}
