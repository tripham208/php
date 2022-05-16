<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportProduct extends Model
{
    use HasFactory;
    protected $table='importProduct';
    protected $fillable=[
        'id',
        'idCustomer',
        'idSupplier',
        'total',
        'time'
    ];
    public $timestamps=false;
}
