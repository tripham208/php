<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class loaisp extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */

    protected $table='loaisp';
    protected $fillable=[
        'id',
        'ten',
        'cha'
    ];
    public $timestamps=false;

}
