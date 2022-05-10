<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\donhang;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use phpDocumentor\Reflection\Types\True_;

class userApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $userList = User::all();
        return response()->json($userList, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $check = User::where('taikhoan', $request->input("taikhoan"))->get();

        if (sizeof($check)>0){
            return [];
        }
        $user = User::create($request->all());
        donhang::create([
            'idnhanvien' => 1,
            'idkhachhang' => $user->id,
            'tongtien' => 0,
            'thanhtoan' => 0,
            'loaidon' => 1
        ]);
        $rs = User::where('id', $user->id)->get();
        return response()->json($rs, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $user->update($request->all());
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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
        //return  $request->input("taikhoan");
        if (Auth::attempt([
            'taikhoan' => $request->input("taikhoan"),
            'password' => $request->input("password")
        ],

        )) {
            $user = User::where('taikhoan', $request->input("taikhoan"))->get();// đi đến admin
            return response()->json($user, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
        if (Auth::attempt([
            'email' =>  $request->input("taikhoan"),
            'password' =>  $request->input("password")
        ],

        )) {
            $user = User::where('email', $request->input("taikhoan"))->get();// đi đến admin
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
        return donhang::where('idkhachhang', $id)->where('loaidon', 1)->get()[0];
    }

    public function getOrderByCustomerId($id)
    {
        $m = new User();
        return $m->getOrder($id);
    }
}
