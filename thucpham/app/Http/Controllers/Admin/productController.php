<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\sanphamRequest;
use App\Models\loaisp;
use App\Models\sanpham;
use App\Models\thuonghieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class productController extends Controller
{
    /**
     * @return mixed
     */
    public function get()
    {
        return sanpham::all();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        return view('admin.sanpham.sanpham', [
            'title' => 'danh sách sản phẩm',
            'data' => $this->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add()
    {
        return view('admin.sanpham.sanpham_add', [
            'title' => 'thêm loại sản phẩm',
            'loaisp' => loaisp::all(),
            'thuonghieu' => thuonghieu::all(),
        ]);
    }

    /**
     * @param sanphamRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(sanphamRequest $request)
    {
        //dd($request->input());
        //tạo bằng model
        try {
            sanpham::create([
                'ten' => (string)$request->input('name'),
                'idloai' => (int)$request->input('loai'),
                'idthuonghieu' => (int)$request->input('thuonghieu'),
                'mota' => (string)$request->input('description'),
                'donvi' => (string)$request->input('donvi'),
                'dongia' => (int)$request->input('dongia'),
                'anh' => (string)$request->input('image'),
                'soluong' => 0
            ]);
            Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        //tạo bằng db
        /*DB::table('loaisp')->insert([
            'ten' => 'kayla@example.com'
        ]);*/
        return redirect()->back();
    }

    public static function loaisp($id)
    {
        try {
            return loaisp::where('id', $id)->first()->ten;
        } catch (\Exception $ex) {

        }

        return "";
    }

    public static function thuonghieu($id)
    {
        try {
            return thuonghieu::where('id', $id)->first()->ten;
        } catch (\Exception $ex) {

        }

        return "";
    }
    public function chitiet(sanpham $sanpham)
    {
        return view('admin.sanpham.sanpham_chitiet', [
            'title' => 'Chi tiết hóa đơn nhập',
            'sanpham'=>$sanpham,
            //'data'=> chitiethoadonnhap::where('idhoadonnhap',$hoadonnhap->id)->get()
        ]);
    }

    public static function list($data)
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'sanpham/chitiet/' . $item->id . '\';">
                    <th ><img src="' . $item->anh . '"  style="width:100%;height:100%;"></th>
                   <th >' . $item->ten . '</th>
                   <th >' . self::thuonghieu($item->idthuonghieu) . '</th>
                   <th >' . $item->soluong . '</th>
                    <th >' . $item->donvi . '</th>
                     <th >' . $item->dongia . '</th>
                   <th>
                        <a  href="/admin/hanghoa/sanpham/edit/' . $item->id . '">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  href="#"
                            onclick="removeRow(' . $item->id . ', \'/admin/hanghoa/sanpham/delete\')">
                            <i class="far fa-trash-alt"></i>
                        </a>

                   </th>
            </tr>
            ';
            // unset($loaisp[$key]);
        }
        return $html;
    }

    public function edit(sanpham $sanpham)
    {
        //dd($loaisp);
        return view('admin.sanpham.sanpham_edit', [
            'title' => 'Chỉnh Sửa loại sản phẩm: ',
            'loaisps' => loaisp::all(),
            'thuonghieu' => thuonghieu::all(),
            'data' => $sanpham
        ]);
    }

    public function update(sanpham $sanpham, sanphamRequest $request)
    {
        $sanpham->ten = (string)$request->input('name');
        $sanpham->idloai = (int)$request->input('loai');
        $sanpham->idthuonghieu = (int)$request->input('thuonghieu');
        $sanpham->mota = (string)$request->input('description');
        $sanpham->donvi = (string)$request->input('donvi');
        $sanpham->dongia = (int)$request->input('dongia');
        $sanpham->anh = (string)$request->input('image');
        $sanpham->save();

        return redirect('admin/hanghoa/sanpham');
    }

    public function delete(Request $request)
    {
        $data = sanpham::where('id', $request->input('id'))->first();
        $result = false;
        if ($data) {
            $result = sanpham::where('id', $request->input('id'))->delete();
        }
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'thành công'
            ]);
        }
        return response()->json([
            'error' => true
        ]);
    }

}
