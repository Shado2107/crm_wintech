<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class QuestionsQuizz
 * @package App\Models
 * @version November 13, 2022, 7:53 pm UTC
 *
 * @property string $libelle
 * @property unsignedInteger $quizz_id
 */
class QuestionQuizz extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'question_quizzs';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'libelle',
        'quizz_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'libelle' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'libelle' => 'required',
        'quizz_id' => 'required'
    ];

    
}
