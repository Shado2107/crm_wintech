<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Points
 * @package App\Models
 * @version November 10, 2022, 1:02 am UTC
 *
 * @property integer $value
 */
class Points extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'points';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'value',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'value' => 'required'
    ];

    
}
