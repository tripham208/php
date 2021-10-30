<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chitietdonhang extends Model
{
    use HasFactory;
    protected $table='chitietdonhang';
    protected $fillable=[
        'id',
        'idhoadon',
        'idsanpham',
        'soluong',
        'dongia',
        'giamgia'
    ];
    public $timestamps=false;

    public function product() {
        return $this->hasOne('App\Models\sanpham','id','idsanpham');
    }
}
