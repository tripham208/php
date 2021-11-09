<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\chitietnhapRequest;
use App\Http\Requests\hoadonnhapRequest;
use App\Models\chitiethoadonnhap;
use App\Models\chitietsanpham;
use App\Models\hoadonnhap;
use App\Models\sanpham;
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

    public static function name($id)
    {
        try {
            return User::where('id', $id)->first()->ten;
        } catch (\Exception $ex) {

        }

        return "";
    }


    public function add()
    {
        return view('admin.hoadonnhap.hoadonnhap_add', [
            'title' => 'Nhập hàng',
            'nhanvien' => User::where('loaitaikhoan', 2)->get(),
            'ncc' => User::where('loaitaikhoan', 3)->get()
        ]);
    }
    public function chitiet(hoadonnhap $hoadonnhap)
    {
        return view('admin.hoadonnhap.hoadonnhap_chitiet', [
            'title' => 'Chi tiết hóa đơn nhập',
            'hoadon'=>$hoadonnhap,
            'data'=> chitiethoadonnhap::where('idhoadonnhap',$hoadonnhap->id)->get()
        ]);
    }
    public function chitiet_add(hoadonnhap $hoadonnhap)
    {

        return view('admin.hoadonnhap.hoadonnhap_addchitiet', [
            'title' => 'Chi tiết hóa đơn nhập',
            'hoadon'=>$hoadonnhap,
            'sanpham'=>sanpham::all(),
            'data'=> chitiethoadonnhap::where('idhoadonnhap',$hoadonnhap->id)->get()
        ]);
    }

    public function store(hoadonnhapRequest $request)
    {
        //dd($request->input());
        //tạo bằng model

        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y/m/d H:i:s');
        try {
            hoadonnhap::create([
                'idnhanvien' => (int)$request->input('nv'),
                'idnhacungcap' => (int)$request->input('ncc'),
                'thoigian'=> $date,
                'tongtien'=>0
            ]);
            Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        //tạo bằng db
        /*DB::table('loaisp')->insert([
            'ten' => 'kayla@example.com'
        ]);*/
        return redirect()->route('edit_nhap',['hoadonnhap'=>hoadonnhap::where('thoigian', $date)->first()->id]);
    }


    public static function list($data)
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'nhap/chitiet/' . $item->id . '\';">
                   <th>' . $item->id . '</th>
                   <th>' . self::name($item->idnhanvien) . '</th>
                   <th>' . self::name($item->idnhacungcap) . '</th>
                   <th>' . $item->tongtien . '</th>
                   <th>' . $item->thoigian . '</th>
            </tr>
            ';
            // unset($loaisp[$key]);
        }
        return $html;
    }
    public function update(hoadonnhap $hoadonnhap, chitietnhapRequest $request)
    {
        //dd($request->input());

        try {
            chitiethoadonnhap::create([
                'idhoadonnhap' => $hoadonnhap->id,
                'idsanpham' => (int)$request->input('sp'),
                'soluong' => (int)$request->input('sl'),
                'dongia' => (int)$request->input('dg'),
                'giamgia' => (int)$request->input('gg'),
                'hansudung' => (string)$request->input('hsd'),
                'serial' => (string)$request->input('sr')
            ]);
            $tien=(int)$request->input('sl')*(int)$request->input('dg');
            if ((int)$request->input('gg')!=null)
                $tien=$tien*(100-(int)$request->input('gg'))/100;
            $hoadonnhap->tongtien+=$tien;
            $hoadonnhap->save();
            //Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        /*echo 'tongtien';
        echo (int)$request->input('sl')*(int)$request->input('dg');
        echo $hoadonnhap->tongtien;
        */
        return redirect()->route('edit_nhap',['hoadonnhap'=>$hoadonnhap->id]);

    }
    public  function delete(hoadonnhap $hoadonnhap){
        //xóa tất cả liên quan hóa đơn nhập hiện tại : 2 bảng hoadonnhap vs chi tiết

        //echo "delete";
        try{
            //xóa bảng chi tiết hóa đơn nhập
            chitiethoadonnhap::where('idhoadonnhap', $hoadonnhap->id)->delete();
            //xóa bảng hóa đơn nhập
            hoadonnhap::where('id', $hoadonnhap->id)->delete();

            return redirect()->route('hoadonnhap');
        }
        catch (\Exception $exception){
            Session::flash('error', $exception->getMessage());
        }
    }


    public function save(hoadonnhap $hoadonnhap)
    {
        //tăng số lượng cho mặt hàng ,tạo chi tiết mặt hàng = số lượng * mỗi sp
        //chitietthu : thứ tự chi tiết hiện tại của sp :(lấy max của chitiet sp tương ứng r +1)
        //ky hiệu random cũng đc
        //id chitet ban = null do chưa bán
        //echo "save";
        $data =chitiethoadonnhap::where('idhoadonnhap',$hoadonnhap->id)->get();
        # echo $data;
        foreach ($data as $key => $item){
            $flight = sanpham::find($item->idsanpham);
            $flight->soluong += $item->soluong;
            $flight->save();

            $val=1;
            $max=chitietsanpham::where('idsanpham',$item->idsanpham)
                ->orderBydesc('chitietthu')->limit(1)
                ->get();
            if ($max!=null)
                foreach ($max as $i)
                    $val=$i->chitietthu;


            for ($x = 0; $x < $item->soluong; $x++) {
                $val+=1;
                chitietsanpham::create([
                    'idsanpham' => $item->idsanpham,
                    'chitietthu' => $val,
                    'dongia' => $flight->dongia,
                    'khoiluong' => $flight->donvi,
                    'kyhieu' => rand(0,1000000),
                    'idchitiethoadonnhap' => $item->id
                ]);

            }

        }

        return redirect()->route('sanpham');
    }


}
