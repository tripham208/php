<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TypeProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryApiController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json(TypeProduct::all(), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }


    public function create()
    {
        //
    }


    public function store(Request $request): JsonResponse
    {
        $product = TypeProduct::where("ten", $request->input('ten'))->get();

        if (sizeof($product) == 0) {
            $billDetail = TypeProduct::create($request->all());
            return response()->json($billDetail, 201);
        }
        $product[0]->father = $request->input('cha');
        $product[0]->save();
        return response()->json($product, 200);


    }


    public function show($id): JsonResponse
    {
        $product = TypeProduct::find($id);
        if (is_null($product)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($product, 200);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id): JsonResponse
    {
        $product = TypeProduct::find($id);
        if (is_null($product)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $product->update($request->all());
        return response()->json($product, 200);
    }


    public function destroy($id): JsonResponse
    {
        $product = TypeProduct::find($id);
        if (is_null($product)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $product->delete();
        return response()->json(null, 200);
    }

    public function getByNameCategory($ten)
    {
        return TypeProduct::where('ten', $ten)->get();
    }

    public function getByNameFatherCategory($cha)
    {
        return TypeProduct::where('cha', $cha)->get();
    }
}
