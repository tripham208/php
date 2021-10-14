<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\hoadonnhapRequest;
use App\Models\hoadonnhap;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class nhapHangController extends Controller
{
    public function index()
    {
        return view('admin.hoadonnhap.hoadonnhap', [
            'title' => 'loại sản phẩm',
            'data' => hoadonnhap::all()
        ]);
    }
    public static function name($id){
        try {
            return User::where('id',$id)->first()->ten;
        }
        catch (\Exception $ex){

        }

        return "";
    }


        public function add()
        {
            return view('admin.hoadonnhap.hoadonnhap_add', [
                'title' => 'Nhập hàng',
                'nhanvien' => User::where('loaitaikhoan',2)->get(),
                'ncc' => User::where('loaitaikhoan',3)->get()
            ]);
        }

        public function store(hoadonnhapRequest $request)
        {
            //dd($request->input());
            //tạo bằng model
            try {
                /*::create([
                    'ten' => (string)$request->input('name'),
                    'cha' => (int)$request->input('parent')
                ]);*/
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


    public static function list($data)
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr>
                   <th>' . $item->id . '</th>
                   <th>' . self::name($item->idnhanvien) . '</th>
                   <th>' . self::name($item->idnhacungcap) . '</th>
                   <th>' . $item->tongtien . '</th>
                   <th>' . $item->thoigian . '</th>
                   <th>
                        <a  href="#"
                            onclick="removeRow(' . "" . ', \'/admin/hanghoa//delete\')">
                            <i class="far fa-trash-alt"></i>
                        </a>

                   </th>
            </tr>
            ';
            // unset($loaisp[$key]);
        }
        return $html;
    }


}
