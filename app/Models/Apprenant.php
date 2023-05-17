<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Apprenant
 * @package App\Models
 * @version October 28, 2022, 12:16 am UTC
 *
 * @property UnsignedInteger $user_id
 * @property UnsignedInteger $couleur_id
 * @property string $telephone
 * @property string $whatsapp
 */
class Apprenant extends Model
{


    public $table = 'apprenants';

    public $fillable = [
        'user_id',
        'client_id',
        'couleur_id',
        'score',
        'telephone',
        'whatsapp'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'telephone' => 'string',
        'whatsapp' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
    ];

    
}
