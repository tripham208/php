<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class donhang extends Model
{
    use HasFactory;
    protected $table='donhang';
    protected $fillable=[
        'id',
        'idkhachhang',
        'idnhanvien',
        'tongtien',
        'thoigian',
        'thanhtoan',
        'loaidon'
    ];
    public $timestamps=false;
    
    public function details() {
        return $this->hasMany('App\Models\chitietdonhang','idhoadon','id');
    }

    public function getOderDetail($id) { 
        return donhang::where('id',$id)->with('details.product')->first();
    }

    public function bill() {
        return $this->hasOne('App\Models\User','id','idkhachhang');
    }
    
}
