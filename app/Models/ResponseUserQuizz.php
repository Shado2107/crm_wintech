<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ResponseUserQuizz
 * @package App\Models
 * @version November 15, 2022, 1:12 am UTC
 *
 * @property integer $note
 * @property integer $question_quizz_id
 * @property integer $user_id
 * @property integer $passer_test_id
 */
class ResponseUserQuizz extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'response_user_quizzs';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'response_quizz_id',
        'question_quizz_id',
        'user_id',
        'passer_test_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'response_quizz_id' => 'integer',
        'question_quizz_id' => 'integer',
        'user_id' => 'integer',
        'passer_test_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'response_quizz_id' => 'required',
        'question_quizz_id' => 'required',
        'passer_test_id' => 'required'
    ];

    
}
