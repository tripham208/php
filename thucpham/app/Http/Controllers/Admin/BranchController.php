<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class branchController extends Controller
{

    public function get()
    {
        return Branch::all();
    }


    public function index()
    {

        return view('admin.branch.branch', [
            'title' => 'thương hiệu',
            'data' => $this->get()
        ]);
    }


    public function add()
    {
        return view('admin.branch.branch_add', [
            'title' => 'thêm loại sản phẩm',
            'data' => $this->get()
        ]);
    }


    public function store(BranchRequest $request)
    {
        //dd($request->input());
        //tạo bằng model
        try {
            Branch::create([
                'name' => (string)$request->input('name'),
                'description' => (string)$request->input('description'),
                'image' => (string)$request->input('image'),
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

    public static function list($data)
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr>
                   <th >' . $item->id . '</th>
                   <th> <img src="' . $item->image . '"  style="width:100%;height:100%;"> </th>
                   <th>' . $item->name . '</th>
                   <th>' . $item->description . '</th>
                   <th>
                        <a  href="/admin/hanghoa/branch/edit/' . $item->id . '">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  href="#"
                            onclick="removeRow(' . $item->id . ', \'/admin/hanghoa/branch/delete\')">
                            <i class="far fa-trash-alt"></i>
                        </a>

                   </th>
            </tr>
            ';
            // unset($typeProduct[$key]);
        }
        return $html;
    }

    public function edit(Branch $branch)
    {
        //dd($typeProduct);
        return view('admin.branch.branch_edit', [
            'title' => 'Chỉnh Sửa loại sản phẩm: ',
            'typeProduct' => $branch,
            'ten' => $branch->name
        ]);
    }

    public function update(Branch $branch, BranchRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $branch->name = (string)$request->input('name');
        $branch->description = $request->input('description');
        $branch->image = $request->input('image');
        $branch->save();

        return redirect('admin/hanghoa/branch');
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = Branch::where('id', $request->input('id'))->first();
        $result = false;
        if ($data) {
            $result = Branch::where('id', $request->input('id'))->delete();
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
