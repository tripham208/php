<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BrandApiController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Branch::all(), 200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $product = Branch::find($id);
        if (is_null($product)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($product, 200);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $product = Branch::find($id);
        if (is_null($product)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $product = Branch::find($id);
        if (is_null($product)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $product->delete();
        return response()->json(null, 200);
    }

    public function getByNameBrand($ten)
    {
        return Branch::where('name', $ten)->get();
    }
}
