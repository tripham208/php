<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImportProduct;
use App\Models\User;

class AccountController extends Controller
{
    public function get(): \Illuminate\Database\Eloquent\Collection|array
    {
        return User::all();
    }

    public function getListByType($type)
    {
        return User::where('typeAccount', $type)->get();
    }


    public function index($type): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $typeTxt = '';
        if ($type == 1) $typeTxt = 'khách hàng';
        elseif ($type == 2) $typeTxt = 'nhân viên';
        else $typeTxt = 'nhà cung cấp';

        return view('admin.account.account', [
            'title' => 'thương hiệu',
            'loai' => $typeTxt,
            'data' => $this->getListByType($type)
        ]);
    }

    /*
        public function add()
        {
            return view('admin.branch.thuonghieu_add', [
                'title' => 'thêm loại sản phẩm',
                'data' => $this->get()
            ]);
        }


        public function store(BranchRequest $request)
        {
            //dd($request->input());
            //tạo bằng model
            try {
                branch::create([
                    'ten' => (string)$request->input('name'),
                    'mota' => (string)$request->input('description'),
                    'anh' => (string)$request->input('image'),
                ]);
                Session::flash('success', 'thành công');
            } catch (\Exception $exception) {
                Session::flash('error', $exception->getMessage());
            }
            //tạo bằng db
            /*DB::table('typeProduct')->insert([
                'ten' => 'kayla@example.com'
            ]);
            return redirect()->back();
        }*/

    public static function list($data): string
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'chitiet/' . $item->id . '\';">
                   <th>' . $item->fullName . '</th>
                   <th>' . $item->username . ' </th>
                   <th>' . $item->phone . '</th>
                   <th>' . $item->email . '</th>
            </tr>
            ';
            // unset($typeProduct[$key]);
        }
        return $html;
    }

    /*
        public function edit(branch $branch)
        {
            //dd($typeProduct);
            return view('admin.branch.thuonghieu_edit', [
                'title' => 'Chỉnh Sửa loại sản phẩm: ' ,
                'typeProduct' => $branch,
                'ten'=>$branch->ten
            ]);
        }
        public function update(branch $branch, BranchRequest $request)
        {
            $branch->ten=(string)$request->input('name');
            $branch->mota=$request->input('description');
            $branch->anh=$request->input('image');
            $branch->save();

            return redirect('admin/hanghoa/branch');
        }
    */
    public function detail(User $account): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $typeAccount = $account->typeAccount;
        if ($typeAccount == 1) {
            $type = 'Khách hàng';
            return redirect()->back();
        } elseif ($typeAccount == 2) {
            $type = 'Quản trị viên';
            return redirect()->back();
        } else {
            $type = 'Nhà cung cấp';

        }
        return view('admin.account.account_detail', [
            'title' => 'Chi tiết ' . $type,
            'loaitaikhoan' => $type,
            'account' => $account,
            'data' => ImportProduct::where('idSupplier', $account->id)->get()
        ]);
    }
}
