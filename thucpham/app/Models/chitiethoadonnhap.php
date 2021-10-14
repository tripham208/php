<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chitiethoadonnhap extends Model
{
    use HasFactory;
    protected $table='chitiethoadonnhap';
    protected $fillable=[
        'id',
        'idhoadonnhap',
        'idsanpham',
        'soluong',
        'dongia',
        'giamgia',
        'hansudung',
        'serial'
    ];
    public $timestamps=false;
}
