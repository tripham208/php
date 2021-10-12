<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sanpham extends Model
{
    use HasFactory;
    protected $table='sanpham';
    protected $fillable=[
        'id',
        'ten',
        'mota',
        'anh',
        'donvi',
        'soluong',
        'dongia',
        'idloai',
        'idthuonghieu'
    ];
    public $timestamps=false;
}
