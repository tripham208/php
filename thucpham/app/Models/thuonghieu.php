<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thuonghieu extends Model
{
    use HasFactory;
    protected $table='thuonghieu';
    protected $fillable=[
        'id',
        'ten',
        'mota',
        'anh'
    ];
    public $timestamps=false;
}
