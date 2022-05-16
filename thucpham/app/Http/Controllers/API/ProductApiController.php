<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{

    public function index()
    {
        //$productList = product::paginate(6);
         $productList = Product::all();
       // return response()->json($productList, 200);
        return response()->json($productList, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($product, 200);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $product->update($request->all());
        return response()->json($product, 200);
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $product->delete();
        return response()->json(null, 200);
    }

    public function getByCategory($idloai)
    {
        return Product::where('idTypeProduct', $idloai)->paginate(6);
    }

    public function searchProduct($name) {
        return Product::where('ten', 'like', '%' . $name . '%')->paginate(6);
    }
}
