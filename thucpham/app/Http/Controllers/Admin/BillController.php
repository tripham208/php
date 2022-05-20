<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Auth;

class BillController extends Controller
{
    public function getByType($type)
    {
        return Order::where('typeOrder', $type)->get();
    }

    public function duyet(Order $order)
    {
        $order->typeOrder = 4;
        $order->idCustomer = Auth::id();
        $order->save();
        $data = OrderDetail::where('idOrder', $order->id)->get();
        # echo $data;
        foreach ($data as $key => $item) {
            $flight = Product::find($item->idProduct);
            $flight->quantity -= $item->quantity;

            $flight->save();
        }
        return redirect()->route('hoadonban', ['loai' => 4]);

    }

    public function giao(Order $order)
    {
        $order->typeOrder = 2;
        $order->save();
        return redirect()->route('hoadonban', ['loai' => 2]);

    }

    public function index($loai)
    {
        $v = '';
        if ($loai == 1) $v = 'Giỏ hàng';
        elseif ($loai == 2) $v = 'Hóa đơn';
        elseif ($loai == 3) $v = 'Đơn đặt';
        else $v = 'Vận đơn';

        return view('admin.orders.order_bill', [
            'title' => 'Danh sách ' . $v,
            'loai' => $v,
            'data' => $this->getByType($loai)
        ]);
    }
    public static function list($data)
    {
        $html = '';
        foreach ($data as $key => $item) {
            $html .= '
            <tr onclick="location.href=\'chitiet/' . $item->id . '\';">
                   <th>' . $item->id . '</th>
                   <th>' . User::getName($item->idCustomer) . '</th>
                   <th>' . User::getName($item->idEmployee) . '</th>
                   <th>' . $item->total . '</th>
                   <th>' . $item->time . '</th>
            </tr>
            ';
            // unset($typeProduct[$key]);
        }
        return $html;
    }

    public function detail(Order $order): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $type = $order->typeOrder;
        if ($type == 1) $typeName = 'Giỏ hàng';
        elseif ($type == 2) $typeName = 'Hóa đơn';
        elseif ($type == 3) $typeName = 'Đơn đặt';
        else $typeName = 'Vận đơn';

        return view('admin.orders.order_detail', [
            'title' => 'Chi tiết ' . $typeName,
            'loaidon' => $typeName,
            'loai' => $type,
            'hoadon' => $order,
            'data' => OrderDetail::where('idOrder', $order->id)->get()
        ]);
    }
}
