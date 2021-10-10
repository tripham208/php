<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\thuonghieuRequest;
use App\Models\thuonghieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class thuonghieuController extends Controller
{

    public  function get(){
        return thuonghieu::all();
    }


    public function index(){

        return view('admin.thuonghieu.thuonghieu', [
            'title' => 'thương hiệu',
            'data'=> $this->get()
        ]);
    }


    public function add(){
        return view('admin.thuonghieu.thuonghieu_add', [
            'title' => 'thêm loại sản phẩm',
            'data'=> $this->get()
        ]);
    }


    public  function store(thuonghieuRequest $request){
        //dd($request->input());
        //tạo bằng model
        try {
            thuonghieu::create([
                'ten'=>(string)$request->input('name'),
                'mota'=>(string)$request->input('description'),
                'anh'=>(string)$request->input('image'),
            ]);
            Session::flash('success','thành công');
        }catch (\Exception $exception){
            Session::flash('error',$exception->getMessage());
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
                   <th> <img src="'.$item->anh.'"  style="width:100%;height:100%;"> </th>
                   <th>' . $item->ten . '</th>
                   <th>' . $item->mota. '</th>
                   <th>
                        <a  href="/admin/hanghoa/thuonghieu/edit/'.$item->id.'">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  href="#"
                            onclick="removeRow(' . $item->id . ', \'/admin/hanghoa/thuonghieu/delete\')">
                            <i class="far fa-trash-alt"></i>
                        </a>

                   </th>
            </tr>
            ';
            // unset($loaisp[$key]);
        }
        return $html;
    }

    public function edit(thuonghieu $thuonghieu)
    {
        //dd($loaisp);
        return view('admin.thuonghieu.thuonghieu_edit', [
            'title' => 'Chỉnh Sửa loại sản phẩm: ' ,
            'loaisp' => $thuonghieu,
            'ten'=>$thuonghieu->ten
        ]);
    }
    public function update(thuonghieu $thuonghieu, thuonghieuRequest $request)
    {
        $thuonghieu->ten=(string)$request->input('name');
        $thuonghieu->mota=$request->input('description');
        $thuonghieu->anh=$request->input('image');
        $thuonghieu->save();

        return redirect('admin/hanghoa/thuonghieu');
    }
    public  function delete(Request $request){
        $data= thuonghieu::where('id',$request->input('id'))->first();
        $result =false;
        if ($data){
            $result = thuonghieu::where('id',$request->input('id'))->delete();
        }
        if ($result){
            return response()->json([
                'error'=>false,
                'message'=>'thành công'
            ]);
        }
        return response()->json([
            'error'=>true
        ]);
    }

}
