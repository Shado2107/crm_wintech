<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ResponseByUser
 * @package App\Models
 * @version November 6, 2022, 7:42 pm UTC
 *
 * @property integer $note
 * @property unsignedInteger $question_id
 * @property unsignedInteger $user_id
 */
class ResponseByUser extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'response_by_users';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'note',
        'question_id',
        'user_id',
        'passer_test_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'note' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'note' => 'required',
        'question_id' => 'required',
        'passer_test_id' => 'required'
    ];

    
}
