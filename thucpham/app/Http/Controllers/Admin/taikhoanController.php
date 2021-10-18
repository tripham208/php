<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\donhang;
use App\Models\hoadonnhap;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class taikhoanController extends Controller
{
    public function get()
    {
        return User::all();
    }

    public function getl($loai)
    {
        return User::where('loaitaikhoan', $loai)->get();
    }


    public function index($loai)
    {
        $v = '';
        if ($loai == 1) $v = 'khách hàng';
        elseif ($loai == 2) $v = 'nhân viên';
        else $v = 'nhà cung cấp';

        return view('admin.taikhoan.taikhoan', [
            'title' => 'thương hiệu',
            'loai' => $v,
            'data' => $this->getl($loai)
        ]);
    }

    /*
        public function add()
        {
            return view('admin.thuonghieu.thuonghieu_add', [
                'title' => 'thêm loại sản phẩm',
                'data' => $this->get()
            ]);
        }


        public function store(thuonghieuRequest $request)
        {
            //dd($request->input());
            //tạo bằng model
            try {
                thuonghieu::create([
                    'ten' => (string)$request->input('name'),
                    'mota' => (string)$request->input('description'),
                    'anh' => (string)$request->input('image'),
                ]);
                Session::flash('success', 'thành công');
            } catch (\Exception $exception) {
                Session::flash('error', $exception->getMessage());
            }
            //tạo bằng db
            /*DB::table('loaisp')->insert([
                'ten' => 'kayla@example.com'
            ]);
            return redirect()->back();
        }*/

    public static function list($data)
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'chitiet/' . $item->id . '\';">
                   <th>' . $item->ten . '</th>
                   <th>' . $item->taikhoan . ' </th>
                   <th>' . $item->sdt . '</th>
                   <th>' . $item->email . '</th>
            </tr>
            ';
            // unset($loaisp[$key]);
        }
        return $html;
    }

    /*
        public function edit(thuonghieu $thuonghieu)
        {
            //dd($loaisp);
            return view('admin.thuonghieu.thuonghieu_edit', [
                'title' => 'Chỉnh Sửa loại sản phẩm: ' ,
                'loaisp' => $thuonghieu,
                'ten'=>$thuonghieu->ten
            ]);
        }
        public function update(thuonghieu $thuonghieu, thuonghieuRequest $request)
        {
            $thuonghieu->ten=(string)$request->input('name');
            $thuonghieu->mota=$request->input('description');
            $thuonghieu->anh=$request->input('image');
            $thuonghieu->save();

            return redirect('admin/hanghoa/thuonghieu');
        }
    */
    public function chitiet(User $taikhoan)
    {
        $loai = $taikhoan->loaitaikhoan;
        if ($loai == 1) {
            $v = 'Khách hàng';
            return redirect()->back();
        }
        elseif ($loai == 2) {
            $v = 'Quản trị viên';
            return redirect()->back();
        }
        else {
            $v = 'Nhà cung cấp';
            return view('admin.taikhoan.taikhoan_chitiet', [
                'title' => 'Chi tiết ' . $v,
                'loaitaikhoan' => $v,
                'taikhoan' => $taikhoan,
                'data' => hoadonnhap::where('idnhacungcap', $taikhoan->id)->get()
            ]);
        }
    }
}
