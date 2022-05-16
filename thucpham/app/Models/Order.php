<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'id',
        'idCustomer',
        'idEmployee',
        'total',
        'time',
        'payment',
        'typeOrder',
        'note'
    ];
    public $timestamps=false;

    public function details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\OrderDetail', 'idhoadon', 'id');
    }

    public function getOderDetail($id) {
        return Order::where('id', $id)->with('details.product')->first();
    }

    public function bill(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('App\Models\User','id','idkhachhang');
    }

}
