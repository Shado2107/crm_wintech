<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ResponseUserChallenge
 * @package App\Models
 * @version November 15, 2022, 8:08 pm UTC
 *
 * @property string $valeur
 * @property unsignedInteger $question_challenge_id
 */
class ResponseUserChallenge extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'response_user_challenges';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'valeur',
        'question_challenge_id',
        'user_id',
        'passer_test_id' 
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'valeur' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'valeur' => 'required',
        'question_challenge_id' => 'required',
        'passer_test_id' => 'required'
    ];

    
}
