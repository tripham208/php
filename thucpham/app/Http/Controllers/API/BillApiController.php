<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class BillApiController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Order::all(), 200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $bill = Order::create($request->all());

        return response()->json($bill, 201);
    }


    public function show($id): \Illuminate\Http\JsonResponse
    {
        $bill = Order::find($id);
        if (is_null($bill)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($bill, 200);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {


        $bill = Order::find($id);
        if (is_null($bill)) {
            return response()->json(["message" => "Not found"], 404);
        }

        $bill->update($request->all());

        if ((int)$request->input('typeOrder') == 3) {
            date_default_timezone_set('Asia/Bangkok');
            $date = date('Y/m/d H:i:s');
            $year = substr($date, 0, 4);
            $yearN = (int)$year + 1;
            $date = str_replace($year, $yearN, $date);
            $bill = Order::create([
                'idEmployee' => 1,
                'idCustomer' => (int)$request->input('idCustomer'),
                'total' => 0,
                'typeOrder' => 1,
                'time' => $date,
                'payment' => 0
            ]);
            return response()->json($bill, 200);
        }


        return response()->json($bill, 200);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $bill = Order::find($id);
        if (is_null($bill)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $bill->delete();
        return response()->json(null, 200);
    }

    public function getByIDCustomer($idCustomer)
    {
        return Order::where('idCustomer', $idCustomer)->get();
    }

    public function getProductByBillId($id)
    {
        $m = new Order();
        return $m->getOderDetail($id);
    }
}
