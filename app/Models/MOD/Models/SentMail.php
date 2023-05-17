<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SentMail
 * @package App\Models
 * @version December 12, 2022, 11:32 pm UTC
 *
 * @property string $type
 * @property UnsignedInteger $user_id
 */
class SentMail extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'sent_mails';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'type',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required',
        'user_id' => 'required'
    ];

    
}
