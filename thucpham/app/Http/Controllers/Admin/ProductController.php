<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Branch;
use App\Models\TypeProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    public function get()
    {
        return Product::all();
    }

    public function index()
    {

        return view('admin.product.product', [
            'title' => 'danh sách sản phẩm',
            'data' => $this->get()
        ]);
    }


    public function add()
    {
        return view('admin.product.product_add', [
            'title' => 'thêm loại sản phẩm',
            'typeProduct' => TypeProduct::all(),
            'branch' => Branch::all(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        //dd($request->input());
        //tạo bằng model
        try {
            Product::create([
                'name' => (string)$request->input('name'),
                'idTypeProduct' => (int)$request->input('loai'),
                'idBranch' => (int)$request->input('branch'),
                'description' => (string)$request->input('description'),
                'unit' => (string)$request->input('donvi'),
                'unitPrice' => (int)$request->input('dongia'),
                'image' => (string)$request->input('image'),
                'quantity' => 0
            ]);
            Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
        //tạo bằng db
        /*DB::table('typeProduct')->insert([
            'ten' => 'kayla@example.com'
        ]);*/
        return redirect()->back();
    }

    public static function loaisp($id)
    {
        try {
            return TypeProduct::where('id', $id)->first()->name;
        } catch (\Exception $ex) {

        }

        return "";
    }

    public static function thuonghieu($id): string
    {
        try {
            return Branch::where('id', $id)->first()->name;
        } catch (\Exception $ex) {

        }

        return "";
    }

    public function chitiet(Product $sanpham): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.product.product_detail', [
            'title' => 'Chi tiết hóa đơn nhập',
            'product'=>$sanpham,
            //'data'=> importProductDetail::where('idhoadonnhap',$importProduct->id)->get()
        ]);
    }

    public static function list($data): string
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'product/chitiet/' . $item->id . '\';">
                    <th ><img src="' . $item->image . '"  style="width:100%;height:100%;"></th>
                   <th >' . $item->name . '</th>
                   <th >' . self::thuonghieu($item->idBranch) . '</th>
                   <th >' . $item->quantity . '</th>
                    <th >' . $item->unit . '</th>
                     <th >' . $item->unitPrice . '</th>
                   <th>
                        <a  href="/admin/hanghoa/product/edit/' . $item->id . '">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  href="#"
                            onclick="removeRow(' . $item->id . ', \'/admin/hanghoa/product/delete\')">
                            <i class="far fa-trash-alt"></i>
                        </a>

                   </th>
            </tr>
            ';
            // unset($typeProduct[$key]);
        }
        return $html;
    }

    public function edit(Product $sanpham)
    {
        //dd($typeProduct);
        return view('admin.product.product_edit', [
            'title' => 'Chỉnh Sửa loại sản phẩm: ',
            'loaisps' => TypeProduct::all(),
            'branch' => Branch::all(),
            'data' => $sanpham
        ]);
    }

    public function update(Product $sanpham, ProductRequest $request)
    {
        $sanpham->name = (string)$request->input('name');
        $sanpham->idTypeProduct = (int)$request->input('loai');
        $sanpham->idBranch = (int)$request->input('branch');
        $sanpham->description = (string)$request->input('description');
        $sanpham->unit = (string)$request->input('donvi');
        $sanpham->unitPrice = (int)$request->input('dongia');
        $sanpham->image = (string)$request->input('image');
        $sanpham->save();

        return redirect('admin/hanghoa/product');
    }

    public function delete(Request $request)
    {
        $data = Product::where('id', $request->input('id'))->first();
        $result = false;
        if ($data) {
            $result = Product::where('id', $request->input('id'))->delete();
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
