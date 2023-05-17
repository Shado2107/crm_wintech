<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class QuestionChallenge
 * @package App\Models
 * @version November 15, 2022, 8:07 pm UTC
 *
 * @property string $libelle
 * @property unsignedInteger $challenge_id
 */
class QuestionChallenge extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'question_challenges';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'libelle',
        'challenge_id'
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
        'challenge_id' => 'required'
    ];

    
}
