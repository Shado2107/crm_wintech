<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ResponsesQuizz
 * @package App\Models
 * @version November 13, 2022, 7:50 pm UTC
 *
 * @property string $valeur
 * @property unsignedInteger $question_quizz_id
 * @property integer $bonne_reponse
 */
class Responses_quizz extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'responses_quizzs';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'valeur',
        'bonne_reponse',
        'video_id',
        'question_quizz_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'valeur' => 'string',
        'bonne_reponse' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'valeur' => 'required',
        'question_quizz_id' => 'required',
        'bonne_reponse' => 'required'
    ];

    
}
