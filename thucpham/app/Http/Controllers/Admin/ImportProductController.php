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

    public static function name($id): string
    {
        try {
            return User::where('id', $id)->first()->fullName;
        } catch (\Exception $ex) {

        }

        return "not found";
    }


    public function add()
    {
        return view('admin.importProduct.importProduct_add', [
            'title' => 'Nhập hàng',
            //'nhanvien' => User::where('typeAccount', 2)->get(),
            'nhanvien' => \Auth::getUser(),
            'ncc' => User::where('typeAccount', 3)->get()
        ]);
    }

    public function detail(ImportProduct $importProduct): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.importProduct.importProduct_detail', [
            'title' => 'Chi tiết hóa đơn nhập',
            'hoadon' => $importProduct,
            'data' => ImportProductDetail::where('idImport', $importProduct->id)->get()
        ]);
    }

    public function addDetail(ImportProduct $importProduct): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        return view('admin.importProduct.importProduct_addDetail', [
            'title' => 'Chi tiết hóa đơn nhập',
            'hoadon' => $importProduct,
            'product' => Product::all(),
            'data' => ImportProductDetail::where('idImport', $importProduct->id)->get()
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
                'time' => $date,
                'total' => 0
            ]);
            Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        //tạo bằng db
        /*DB::table('typeProduct')->insert([
            'ten' => 'kayla@example.com'
        ]);*/
        return redirect()->route('edit_nhap', ['importProduct' => ImportProduct::where('time', $date)->first()->id]);
    }


    public static function list($data): string
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'nhap/chitiet/' . $item->id . '\';">
                   <th>' . $item->id . '</th>
                   <th>' . self::name($item->idEmployee) . '</th>
                   <th>' . self::name($item->idSupplier) . '</th>
                   <th>' . $item->total . '</th>
                   <th>' . $item->time . '</th>
            </tr>
            ';
            // unset($typeProduct[$key]);
        }
        return $html;
    }

    public function update(ImportProduct $importProduct, importDetailRequest $request): \Illuminate\Http\RedirectResponse
    {
        //dd($request->input());

        try {
            ImportProductDetail::create([
                'idImport' => $importProduct->id,
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
            $importProduct->total += $tien;
            $importProduct->save();
            //Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        /*echo 'tongtien';
        echo (int)$request->input('sl')*(int)$request->input('dg');
        echo $importProduct->tongtien;
        */
        return redirect()->route('edit_nhap', ['importProduct' => $importProduct->id]);

    }

    public function delete(ImportProduct $importProduct): string|\Illuminate\Http\RedirectResponse
    {
        //xóa tất cả liên quan hóa đơn nhập hiện tại : 2 bảng importProduct vs chi tiết

        //echo "delete";
        try {
            //xóa bảng chi tiết hóa đơn nhập
            ImportProductDetail::where('idImport', $importProduct->id)->delete();
            //xóa bảng hóa đơn nhập
            ImportProduct::where('id', $importProduct->id)->delete();

            return redirect()->route('importProduct');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }


    public function save(ImportProduct $importProduct): \Illuminate\Http\RedirectResponse
    {
        //tăng số lượng cho mặt hàng ,tạo chi tiết mặt hàng = số lượng * mỗi sp
        //chitietthu : thứ tự chi tiết hiện tại của sp :(lấy max của chitiet sp tương ứng r +1)
        //ky hiệu random cũng đc
        //id chitet ban = null do chưa bán
        //echo "save";
        $data = ImportProductDetail::where('idImport', $importProduct->id)->get();
        # echo $data;
        foreach ($data as $key => $item) {
            $product = Product::find($item->idProduct);
            $product->quantity += $item->quantity;
            $product->save();

            $val = 1;
            $max = ProductDetail::where('idProduct', $item->idProduct)
                ->orderBydesc('numberOfDetail')->limit(1)
                ->get();
            if ($max != null)
                foreach ($max as $i)
                    $val = $i->numberOfDetail;


            for ($x = 0; $x < $item->quantity; $x++) {
                $val += 1;
                ProductDetail::create([
                    'idProduct' => $item->idProduct,
                    'numberOfDetail' => $val,
                    'unitPrice' => $product->unitPrice,
                    'weight' => $product->unit,
                    'serial' => rand(0, 100000000),
                    'idImportProductDetail' => $item->id
                ]);

            }

        }

        return redirect()->route('product');
    }


}
