<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Token extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'tokens';

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public $fillable = [
        'tokenable_type',
        'token',
        'refresh_token',
        'state',
        'user_id',
        'scope',
        'expired_at',
        'last_used_at'
    ];

}
