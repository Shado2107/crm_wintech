<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Question
 * @package App\Models
 * @version November 2, 2022, 3:09 am UTC
 *
 * @property string $libelle
 * @property string $type
 * @property integer $quizz_id
 * @property integer $roue_de_vie_id
 * @property integer $canva_mini_disq_id
 * @property integer $domaine_id
 */
class Question extends Model
{


    public $table = 'questions';
    



    public $fillable = [
        'libelle',
        'type',
        'quizz_id',
        'roue_de_vie_id',
        'mini_disq_id',
        'competence_id',
        'domaine_id',
        'image_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'libelle' => 'string',
        'type' => 'string',
        'quizz_id' => 'integer',
        'roue_de_vie_id' => 'integer',
        'canva_mini_disq_id' => 'integer',
        'domaine_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'libelle' => 'required',
        'type' => 'required'
    ];

    
}
