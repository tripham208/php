<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportProductDetail extends Model
{
    use HasFactory;

    protected $table = 'importProductDetail';
    protected $fillable = [
        'id',
        'idImport',
        'idProduct',
        'quantity',
        'unitPrice',
        'discount',
        'expiry',
        'serial'
    ];
    public $timestamps = false;
}
