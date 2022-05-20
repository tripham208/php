<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeProductRequest;
use App\Models\TypeProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{


    public function get()
    {
        return TypeProduct::all();
    }


    public function index()
    {

        return view('admin.typeProduct.typeProduct', [
            'title' => 'loại sản phẩm',
            'typeProduct' => $this->get()
        ]);
    }


    public function add()
    {
        return view('admin.typeProduct.typeProduct_add', [
            'title' => 'thêm loại sản phẩm',
            'typeProduct' => $this->get()
        ]);
    }


    public function store(TypeProductRequest $request)
    {
        //dd($request->input());
        //tạo bằng model
        try {
            TypeProduct::create([
                'name' => (string)$request->input('name'),
                'father' => (int)$request->input('parent')
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

    public static function name($id): string
    {
        try {
            return TypeProduct::where('id', $id)->first()->name;
        } catch (\Exception $ex) {

        }

        return "";
    }

    public static function list($typeProduct): string
    {
        $html = '';
        foreach ($typeProduct as $key => $typeProduct) {
            $html .= '
            <tr>
                   <th>' . $typeProduct->id . '</th>
                   <th>' . $typeProduct->name . '</th>
                   <th>' . self::name($typeProduct->father) . '</th>
                   <th>
                        <a  href="/admin/hanghoa/typeProduct/edit/' . $typeProduct->id . '">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  href="#"
                            onclick="removeRow(' . $typeProduct->id . ', \'/admin/hanghoa/typeProduct/delete\')">
                            <i class="far fa-trash-alt"></i>
                        </a>

                   </th>
            </tr>
            ';
            // unset($typeProduct[$key]);
        }
        return $html;
    }

    public function edit(TypeProduct $typeProduct): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        //dd($typeProduct);
        return view('admin.typeProduct.typeProduct_edit', [
            'title' => 'Chỉnh Sửa loại sản phẩm: ',
            'loaisps' => $this->get(),
            'typeProduct' => $typeProduct
        ]);
    }

    public function update(TypeProduct $typeProduct, TypeProductRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $typeProduct->name = (string)$request->input('name');
        $typeProduct->father = $request->input('parent');
        $typeProduct->save();

        return redirect('admin/hanghoa/typeProduct');
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = TypeProduct::where('id', $request->input('id'))->first();
        $result = false;
        if ($data) {
            $result = TypeProduct::where('id', $request->input('id'))->delete();
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
