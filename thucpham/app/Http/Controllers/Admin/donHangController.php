<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\chitietdonhang;
use App\Models\donhang;
use App\Models\sanpham;
use App\Models\User;
use Illuminate\Http\Request;

class donHangController extends Controller
{
    public function getl($loai)
    {
        return donhang::where('loaidon',$loai)->get();
    }
    public function duyet(donhang $hoadonban)
    {
        $hoadonban->loaidon=4;
        $hoadonban->save();
        $data =chitietdonhang::where('idhoadon',$hoadonban->id)->get();
        # echo $data;
        foreach ($data as $key => $item){
            $flight = sanpham::find($item->idsanpham);
            $flight->soluong -= $item->soluong;

            $flight->save();
        }
        return redirect()->route('hoadonban',['loai'=>4]);

    }
    public function giao(donhang $hoadonban)
    {
        $hoadonban->loaidon=2;
        $hoadonban->save();
        return redirect()->route('hoadonban',['loai'=>2]);

    }
    public function index($loai)
    {
        $v='';
        if ($loai==1) $v='Giỏ hàng';
        elseif ($loai==2) $v='Hóa đơn';
        elseif ($loai==3) $v='Đơn đặt';
        else $v='Vận đơn';

        return view('admin.donhang.donhang_hoadon', [
            'title' => 'Danh sách '.$v,
            'loai' => $v,
            'data' => $this->getl($loai)
        ]);
    }
    public static function list($data)
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'chitiet/' . $item->id . '\';">
                   <th>' . $item->id . '</th>
                   <th>' . User::name($item->idnhanvien) . '</th>
                   <th>' . User::name($item->idkhachhang) . '</th>
                   <th>' . $item->tongtien . '</th>
                   <th>' . $item->thoigian . '</th>
            </tr>
            ';
            // unset($loaisp[$key]);
        }
        return $html;
    }
    public function chitiet(donhang $hoadonban)
    {
        $loai =$hoadonban->loaidon;
        if ($loai==1) $v='Giỏ hàng';
        elseif ($loai==2) $v='Hóa đơn';
        elseif ($loai==3) $v='Đơn đặt';
        else $v='Vận đơn';

        return view('admin.donhang.hoadonban_chitiet', [
            'title' => 'Chi tiết '.$v,
            'loaidon'=> $v,
            'loai'=>$loai,
            'hoadon'=>$hoadonban,
            'data'=> chitietdonhang::where('idhoadon',$hoadonban->id)->get()
        ]);
    }
}
