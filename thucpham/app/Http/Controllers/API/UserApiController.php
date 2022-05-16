<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{

    public function index(): \Illuminate\Http\JsonResponse
    {
        $userList = User::all();
        return response()->json($userList, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }


    public function create()
    {
        //
    }


    public function store(Request $request): \Illuminate\Http\JsonResponse|array
    {
        $check = User::where('account', $request->input("account"))->get();

        if (sizeof($check)>0){
            return [];
        }
        $user = User::create($request->all());
        Order::create([
            'idCustomer' => 1,
            'idEmployee' => $user->id,
            'total' => 0,
            'payment' => 0,
            'typeOrder' => 1
        ]);
        $rs = User::where('id', $user->id)->get();
        return response()->json($rs, 201);

    }


    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($user, 200);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $user->update($request->all());
        return response()->json($user, 200);
    }


    public function destroy($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $user->delete();
        return response()->json(null, 200);
    }

    public function getByEmail($email)
    {
        return User::where('email', $email)->get();
    }

    public function login(Request $request)
    {
        //return  $request->input("account");
        if (Auth::attempt([
            'account' => $request->input("account"),
            'password' => $request->input("password")
        ],

        )) {
            $user = User::where('account', $request->input("account"))->get();// đi đến admin
            return response()->json($user, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
        if (Auth::attempt([
            'email' =>  $request->input("account"),
            'password' =>  $request->input("password")
        ],

        )) {
            $user = User::where('email', $request->input("account"))->get();// đi đến admin
            return response()->json($user, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
        return [];
    }
    public function getAccByPhone(Request $request)
    {
        return User::where('sdt', $request->input("phone"))->get();
    }

    public function getCart($id)
    {
        return Order::where('idkhachhang', $id)->where('loaidon', 1)->get()[0];
    }

    public function getOrderByCustomerId($id)
    {
        $m = new User();
        return $m->getOrder($id);
    }
}
