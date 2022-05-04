<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\loaisp;
use Illuminate\Http\Request;
use App\Models\chitietdonhang;

class billDetailApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(chitietdonhang::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $product = chitietdonhang::where("idsanpham",$request->input('idsanpham'))
            ->where("idhoadon",$request->input('idhoadon'))->get();
       // return response()->json($product, 201);
        if (sizeof($product)==0 ) {
            $billDetail = chitietdonhang::create($request->all());
            return response()->json($billDetail, 201);
        }
        $product[0]->soluong = $request->input('soluong');
        $product[0]->dongia = $request->input('dongia');
        $product[0]->giamgia = $request->input('giamgia');
        $product[0]->save();
        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $billDetail = chitietdonhang::find($id);
        if (is_null($billDetail)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($billDetail, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $idsanpham, $iddonhang)
    {
        $billDetail = chitietdonhang::where('idsanpham', $idsanpham)->where('iddonhang', $iddonhang)->get()[0];
        if (is_null($billDetail)) {
           return response()->json(["message" => "Not found"], 404);
        }
        $billDetail->update($request->all());
        return response()->json($billDetail, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $billDetail = chitietdonhang::find($id);
        if (is_null($billDetail)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $billDetail->delete();
        return response()->json(null, 200);
    }

    public function getByIDBill($idhoadon)
    {
        return chitietdonhang::where('idhoadon', $idhoadon)->get();
    }

    public function getByIDProduct($idsanpham)
    {
        return chitietdonhang::where('idsanpham', $idsanpham)->get();
    }
}
