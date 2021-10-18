<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\donhang;

class billApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(donhang::all(), 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = donhang::find($id);
        if (is_null($bill)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($bill, 200);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = donhang::find($id);
        if (is_null($bill)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $bill->update($request->all());
        return response()->json($bill, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = donhang::find($id);
        if (is_null($bill)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $bill->delete();
        return response()->json(null, 200);
    }

    public function getByIDCustomer($idkhachhang)
    {
        return donhang::where('idkhachhang', $idkhachhang)->get();
    }
}
