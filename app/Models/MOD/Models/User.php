<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'prenom', 'email', 'avatar', 'phone', 'linkedin', 'role_id', 'code_promo', 'address_id', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at', 'provider_name', 'provider_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $login = [
        'email' => 'required',
        'password' => 'required'
    ];

    public static $refresh_token = [
        'refresh_token' => 'required'
    ];

    public static $register = [
        'nom' => 'required',
        'prenom' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed'
    ];

    public function certifications()
    {
        return $this->hasMany('App\Models\Certification');
    }

    public function providers()
    {
        return $this->hasMany(Provider::class,'user_id','id');
    }
}
