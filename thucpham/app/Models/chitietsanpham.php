<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chitietsanpham extends Model
{
    use HasFactory;
    protected $table='chitietsanpham';
    protected $fillable=[
        'id',
        'idsanpham',
        'chitietthu',
        'khoiluong',
        'dongia',
        'kyhieu',
        'idchitiethoadonnhap',
        'idchitiethoadonban'

    ];
    public $timestamps=false;
}
