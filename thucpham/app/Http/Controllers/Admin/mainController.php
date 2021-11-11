<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class mainController extends Controller
{
    public function index()
    {
        $doanhthuthang=\DB::table('hoadonthang')->get();
        $thang=0;
        if ($doanhthuthang[0]->doanhthu!=null) $thang=$doanhthuthang[0]->doanhthu;
        $doanhthunam=\DB::table('hoadonnam')->get();
        $nam=0;
        if ($doanhthunam[0]->doanhthu!=null) $nam=$doanhthunam[0]->doanhthu;
        $dondat=\DB::table('donhang')->where("loaidon",3)->count();
        $vandon=\DB::table('donhang')->where("loaidon",4)->count();
        return view('admin.dashboard', [
            'title' => 'admin',
            'doanhthuthang'=> $thang,
            'doanhthunam'=> $nam,
            'dondat'=>$dondat,
            'vandon'=>$vandon
        ]);
        /*
         * create view hoadonnam as
select count(`hd`.`id`) AS `sohd`, sum(`hd`.`tongtien`) AS `doanhthu`
from `thucpham`.`donhang` `hd`
where year(`hd`.`thoigian`) = year(curtime())
  and `hd`.`loaidon` = 2;
create  view hoadonthang as
select count(`hd`.`id`) AS `sohd`, sum(`hd`.`tongtien`) AS `doanhthu`
from `thucpham`.`donhang` `hd`
where year(`hd`.`thoigian`) = year(curtime())
  and month(`hd`.`thoigian`) = month(curtime())
  and `hd`.`loaidon` = 2;
         */

    }
}
