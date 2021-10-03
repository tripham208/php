<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    public function index()
    {
        return view('admin.login', [
            'title' => 'login admin'
        ]);

    }

    public function check(Request $request)
    {
        //hien thong tin input
        //dd($request->input());
        $this->validate($request, [
            'username' => 'required',//bắt buộc
            'password' => 'required'
        ]);
        if (Auth::attempt([
            'taikhoan' => $request->input('username'),
            'matkhau' => $request->input('password')
        ],

            $request->input('remember'))) {
            return redirect()->route('admin');// đi đến admin
        }
        Session::flash('error', 'tài khoản hoặc mật khẩu không chính xác');
        return redirect()->back();
    }
}
