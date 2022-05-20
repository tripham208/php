<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\TypeProduct;
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
                'idTypeProduct' => $request->input('idTypeProduct'),
                'idBranch' => $request->input('branch'),
                'description' => (string)$request->input('description'),
                'unit' => (string)$request->input('unit'),
                'unitPrice' => (int)$request->input('unitPrice'),
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

    public static function type($id): string
    {
        try {
            return TypeProduct::where('id', $id)->first()->name;
        } catch (\Exception $ex) {

        }

        return "";
    }

    public static function branch($id): string
    {
        try {
            return Branch::where('id', $id)->first()->name;
        } catch (\Exception $ex) {

        }

        return "";
    }

    public function detail(Product $product): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.product.product_detail', [
            'title' => 'Chi tiết hóa đơn nhập',
            'product' => $product,
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
                   <th >' . self::branch($item->idBranch) . '</th>
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

    public function edit(Product $product)
    {
        //dd($typeProduct);
        return view('admin.product.product_edit', [
            'title' => 'Chỉnh Sửa loại sản phẩm: ',
            'typeProducts' => TypeProduct::all(),
            'branch' => Branch::all(),
            'data' => $product
        ]);
    }

    public function update(Product $product, ProductRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        //dd($request->input());

        try {
            $product->name = (string)$request->input('name');
            $product->idTypeProduct = $request->input('idTypeProduct');
            $product->idBranch = $request->input('branch');
            $product->description = (string)$request->input('description');
            $product->unit = (string)$request->input('unit');
            $product->unitPrice = (int)$request->input('unitPrice');
            $product->image = (string)$request->input('image');
            $product->save();
            Session::flash('success', 'thành công');
        } catch (\Exception $exception) {
            Session::flash('error', $exception->getMessage());
            return redirect()->back();
        }
        return redirect('admin/hanghoa/product');

    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
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
