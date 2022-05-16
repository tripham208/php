<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TypeProduct extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */

    protected $table='typeProduct';
    protected $fillable=[
        'id',
        'name',
        'father'
    ];
    public $timestamps=false;

}
