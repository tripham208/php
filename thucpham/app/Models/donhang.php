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
}
