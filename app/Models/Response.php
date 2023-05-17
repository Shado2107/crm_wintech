<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Response
 * @package App\Models
 * @version November 4, 2022, 5:12 pm UTC
 *
 * @property string $valeur
 * @property unsignedInteger $question_id
 * @property integer $bonne_response
 */
class Response extends Model
{


    public $table = 'responses';
    



    public $fillable = [
        'valeur',
        'question_id',
        'bonne_response'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'valeur' => 'string',
        'bonne_response' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'valeur' => 'required',
        'question_id' => 'required'
    ];

    
}
