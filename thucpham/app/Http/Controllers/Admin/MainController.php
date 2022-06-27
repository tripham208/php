<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;

class MainController extends Controller
{
    public function index()
    {
        $orderMonth = DB::table('order-month')->get();
        $turnoverMonth = 0;
        if ($orderMonth[0]->turnover != null) $turnoverMonth = $orderMonth[0]->turnover;
        $turnoverMonth = number_format($turnoverMonth);
        $orderYear = DB::table('order-year')->get();
        $turnoverYear = 0;
        if ($orderYear[0]->turnover != null) $turnoverYear = $orderYear[0]->turnover;
        $turnoverYear = number_format($turnoverYear);
        $dondat = DB::table('orders')->where("typeOrder", 3)->count();
        $vandon = DB::table('orders')->where("typeOrder", 4)->count();


        $ds = [];
        for ($x = 1; $x <= 12; $x++) {
            $ds[] = DB::table('this-year')->where("month", $x)->sum("total");
        }
        $td = [];
        for ($x = 2; $x <= 4; $x++) {
            $td[] = DB::table('today')->where("typeOrder", $x)->count();
        }


        return view('admin.dashboard', [
            'title' => 'admin',
            'orderMonth' => $turnoverMonth,
            'orderYear' => $turnoverYear,
            'dondat' => $dondat,
            'vandon' => $vandon,
            'list' => $ds,
            'today' => $td
        ]);

    }
}
