<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\importBillProductRequest;
use App\Http\Requests\importDetailRequest;
use App\Models\ImportProduct;
use App\Models\ImportProductDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class ImportProductController extends Controller
{
    public function index()
    {
        return view('admin.importProduct.importProduct', [
            'title' => 'loại sản phẩm',
            'data' => ImportProduct::all()
        ]);
    }

    public static function name($id)
    {
        try {
            return User::where('id', $id)->first()->name;
        } catch (\Exception $ex) {

        }

        return "";
    }


    public function add()
    {
        return view('admin.importProduct.importProduct_add', [
            'title' => 'Nhập hàng',
            //'nhanvien' => User::where('loaitaikhoan', 2)->get(),
            'nhanvien' => \Auth::getUser(),
            'ncc' => User::where('loaitaikhoan', 3)->get()
        ]);
    }

    public function detail(ImportProduct $importOrder): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.importProduct.importProduct_detail', [
            'title' => 'Chi tiết hóa đơn nhập',
            'hoadon' => $importOrder,
            'data' => ImportProductDetail::where('idhoadonnhap', $importOrder->id)->get()
        ]);
    }

    public function addDetail(ImportProduct $hoadonnhap): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        return view('admin.importProduct.importProduct_addDetail', [
            'title' => 'Chi tiết hóa đơn nhập',
            'hoadon' => $hoadonnhap,
            'product' => Product::all(),
            'data' => ImportProductDetail::where('idhoadonnhap', $hoadonnhap->id)->get()
        ]);
    }

    public function store(importBillProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        //dd($request->input());
        //tạo bằng model

        date_default_timezone_set('Asia/Bangkok');
        $date = date('Y/m/d H:i:s');
        try {
            ImportProduct::create([
                'idCustomer' => (int)$request->input('nv'),
                'idSupplier' => (int)$request->input('ncc'),
                'total' => $date,
                'time' => 0
            ]);
            Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        //tạo bằng db
        /*DB::table('typeProduct')->insert([
            'ten' => 'kayla@example.com'
        ]);*/
        return redirect()->route('edit_nhap', ['importProduct' => ImportProduct::where('thoigian', $date)->first()->id]);
    }


    public static function list($data): string
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'nhap/chitiet/' . $item->id . '\';">
                   <th>' . $item->id . '</th>
                   <th>' . self::name($item->idCustomer) . '</th>
                   <th>' . self::name($item->idSupplier) . '</th>
                   <th>' . $item->total . '</th>
                   <th>' . $item->time . '</th>
            </tr>
            ';
            // unset($typeProduct[$key]);
        }
        return $html;
    }

    public function update(ImportProduct $i, importDetailRequest $request): \Illuminate\Http\RedirectResponse
    {
        //dd($request->input());

        try {
            ImportProductDetail::create([
                'idImportDetail' => $i->id,
                'idProduct' => (int)$request->input('sp'),
                'quantity' => (int)$request->input('sl'),
                'unitPrice' => (int)$request->input('dg'),
                'discount' => (int)$request->input('gg'),
                'expiry' => (string)$request->input('hsd'),
                'serial' => (string)$request->input('sr')
            ]);
            $tien = (int)$request->input('sl') * (int)$request->input('dg');
            if ((int)$request->input('gg') != null)
                $tien = $tien * (100 - (int)$request->input('gg')) / 100;
            $i->total += $tien;
            $i->save();
            //Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        /*echo 'tongtien';
        echo (int)$request->input('sl')*(int)$request->input('dg');
        echo $importProduct->tongtien;
        */
        return redirect()->route('edit_nhap', ['importProduct' => $i->id]);

    }

    public function delete(ImportProduct $data)
    {
        //xóa tất cả liên quan hóa đơn nhập hiện tại : 2 bảng importProduct vs chi tiết

        //echo "delete";
        try {
            //xóa bảng chi tiết hóa đơn nhập
            ImportProductDetail::where('idImportDetail', $data->id)->delete();
            //xóa bảng hóa đơn nhập
            ImportProduct::where('id', $data->id)->delete();

            return redirect()->route('importProduct');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
    }


    public function save(ImportProduct $hoadonnhap)
    {
        //tăng số lượng cho mặt hàng ,tạo chi tiết mặt hàng = số lượng * mỗi sp
        //chitietthu : thứ tự chi tiết hiện tại của sp :(lấy max của chitiet sp tương ứng r +1)
        //ky hiệu random cũng đc
        //id chitet ban = null do chưa bán
        //echo "save";
        $data = ImportProductDetail::where('idhoadonnhap', $hoadonnhap->id)->get();
        # echo $data;
        foreach ($data as $key => $item) {
            $flight = Product::find($item->idsanpham);
            $flight->soluong += $item->soluong;
            $flight->save();

            $val = 1;
            $max = ProductDetail::where('idsanpham', $item->idsanpham)
                ->orderBydesc('chitietthu')->limit(1)
                ->get();
            if ($max != null)
                foreach ($max as $i)
                    $val = $i->chitietthu;


            for ($x = 0; $x < $item->soluong; $x++) {
                $val += 1;
                ProductDetail::create([
                    'idsanpham' => $item->idsanpham,
                    'chitietthu' => $val,
                    'dongia' => $flight->dongia,
                    'khoiluong' => $flight->donvi,
                    'kyhieu' => rand(0, 100000000),
                    'idchitiethoadonnhap' => $item->id
                ]);

            }

        }

        return redirect()->route('product');
    }


}
