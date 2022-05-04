<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\chitietdonhang;
use Illuminate\Http\Request;
use App\Models\loaisp;
use Validator;

class categoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(loaisp::all(), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = loaisp::where("ten",$request->input('ten'))->get();

        if (sizeof($product)==0 ) {
            $billDetail = loaisp::create($request->all());
            return response()->json($billDetail, 201);
        }
        $product[0]->cha = $request->input('cha');
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
        $product = loaisp::find($id);
        if (is_null($product)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($product, 200);
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
    public function update(Request $request, $id)
    {
        $product = loaisp::find($id);
        if (is_null($product)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $product->update($request->all());
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = loaisp::find($id);
        if (is_null($product)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $product->delete();
        return response()->json(null, 200);
    }

    public function getByNameCategory($ten)
    {
        return loaisp::where('ten', $ten)->get();
    }
    public function getByNameFatherCategory($cha)
    {
        return loaisp::where('cha', $cha)->get();
    }
}
