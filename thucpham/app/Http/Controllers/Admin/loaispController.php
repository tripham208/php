<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\loaispRequest;
use App\Models\loaisp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;
use function PHPUnit\Framework\exactly;

/**
 *
 */
class loaispController extends Controller
{

    /**
     * @return mixed
     */
    public  function get(){
        return loaisp::all();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){

        return view('admin.loaisp.loaisp', [
            'title' => 'loại sản phẩm',
            'loaisp'=> $this->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add(){
        return view('admin.loaisp.loaisp_add', [
            'title' => 'thêm loại sản phẩm',
            'loaisp'=> $this->get()
        ]);
    }

    /**
     * @param loaispRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function store(loaispRequest $request){
        //dd($request->input());
        //tạo bằng model
        try {
            loaisp::create([
                'ten'=>(string)$request->input('name'),
                'cha'=>(int)$request->input('parent')
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
    public static function name($id){
        try {
            return loaisp::where('id',$id)->first()->ten;
        }
        catch (\Exception $ex){

        }

        return "";
    }
    public static function list($loaisp)
    {
        $html = '';
        foreach ($loaisp as $key => $loaisp) {
            $html .= '
            <tr>
                   <th>' . $loaisp->id . '</th>
                   <th>' . $loaisp->ten . '</th>
                   <th>' . self::name($loaisp->cha). '</th>
                   <th>
                        <a  href="/admin/hanghoa/loaisp/edit/'.$loaisp->id.'">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a  href="#"
                            onclick="removeRow(' . $loaisp->id . ', \'/admin/hanghoa/loaisp/delete\')">
                            <i class="far fa-trash-alt"></i>
                        </a>

                   </th>
            </tr>
            ';
            // unset($loaisp[$key]);
        }
        return $html;
    }
    public function edit(loaisp $loaisp)
    {
        //dd($loaisp);
        return view('admin.loaisp.loaisp_edit', [
            'title' => 'Chỉnh Sửa loại sản phẩm: ' ,
            'loaisps' => $this->get(),
            'loaisp'=>$loaisp
        ]);
    }
    public function update(loaisp $loaisp, loaispRequest $request)
    {
        $loaisp->ten=(string)$request->input('name');
        $loaisp->cha=$request->input('parent');
        $loaisp->save();

        return redirect('admin/hanghoa/loaisp');
    }
    public  function delete(Request $request){
        $data= loaisp::where('id',$request->input('id'))->first();
        $result =false;
        if ($data){
            $result = loaisp::where('id',$request->input('id'))->delete();
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
