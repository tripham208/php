<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillDetailApiController extends Controller
{

    public function index(): JsonResponse
    {
        return response()->json(OrderDetail::all(), 200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request): JsonResponse
    {
        $billDetail = OrderDetail::create($request->all());
        return response()->json($billDetail, 201);
    }


    public function show($id): JsonResponse
    {
        $billDetail = OrderDetail::find($id);
        if (is_null($billDetail)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($billDetail, 200);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id): JsonResponse
    {
        $billDetail = OrderDetail::where('id', $id)->get()[0];
        if (is_null($billDetail)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $billDetail->update($request->all());
        return response()->json($billDetail, 200);
    }


    public function destroy($id): JsonResponse
    {
        $billDetail = OrderDetail::find($id);
        if (is_null($billDetail)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $billDetail->delete();
        return response()->json(null, 200);
    }

    public function getByIDBill($idOrder)
    {
        return OrderDetail::where('idOrder', $idOrder)->get();
    }

    public function getByIDProduct($idProduct)
    {
        return OrderDetail::where('idProduct', $idProduct)->get();
    }
}
