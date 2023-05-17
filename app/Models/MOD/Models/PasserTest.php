<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class PasserTest
 * @package App\Models
 * @version November 2, 2022, 2:58 am UTC
 *
 * @property integer $roue_de_vie_id
 * @property integer $mini_disq_id
 * @property integer $quizz_id
 * @property integer $competence_id
 * @property integer $user_id
 * @property integer $point_id
 */
class PasserTest extends Model
{


    public $table = 'passer_tests';

    public $fillable = [
        'type',
        'roue_de_vie_id',
        'mini_disc_id',
        'competence_id',
        'quizz_id',
        'challenge_id',
        'user_id',
        'point_id',
        'state'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'roue_de_vie_id' => 'integer',
        'mini_disq_id' => 'integer',
        'quizz_id' => 'integer',
        'competence_id' => 'integer',
        'user_id' => 'integer',
        'point_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required'
    ];

    
}
