<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        Auth::logout();
        return view('admin.login', [
            'title' => 'login admin'
        ]);

    }

    /**
     * @throws ValidationException
     */
    public function check(Request $request): \Illuminate\Http\RedirectResponse
    {
        //hien thong tin input
        //dd($request->input());
        $this->validate($request, [
            'username' => 'required',//bắt buộc
            'password' => 'required'
        ]);
        if (Auth::attempt([
            'username' => "{$request->input('username')}",
            'password' => $request->input('password')
        ],

            $request->input('remember'))) {
            return redirect()->route('admin');// đi đến admin
        }
        Session::flash('error', 'Tài khoản hoặc mật khẩu không chính xác');
        return redirect()->back();
    }
}
