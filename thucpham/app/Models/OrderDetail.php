<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orderDetail';
    protected $fillable = [
        'id',
        'idOrder',
        'idProduct',
        'quantity',
        'unitPrice',
        'discount'
    ];
    public $timestamps=false;

    public function product(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\Product','id','idProduct');
    }
}
