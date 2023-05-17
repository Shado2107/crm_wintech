<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ValidationEmail
 * @package App\Models
 * @version January 5, 2023, 6:35 pm UTC
 *
 * @property integer $code
 * @property unsignedInteger $user_id
 * @property string $email
 */
class ValidationEmail extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'validation_emails';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'code',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'integer',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required',
        'email' => 'required'
    ];

    
}
