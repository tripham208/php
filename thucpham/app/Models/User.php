<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model ;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'account';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'fullName',
        'email',
        'password',
        'username',
        'phone',
        'address',
        'typeAccount'
    ];



    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function name($id): string
    {
        try {
            return User::where('id', $id)->first()->fullName;
        } catch (\Exception $ex) {

        }

        return "";
    }

    public function idOrder(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Order','idkhachhang','id');
    }

    public function getOrder($id) {
        return User::where('id',$id)->with('idOrder.details.product')->first();
    }
}
