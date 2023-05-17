<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class Domaine
 * @package App\Models
 * @version November 2, 2022, 3:11 am UTC
 *
 * @property string $libelle
 * @property integer $parent
 */
class Domaine extends Model
{


    public $table = 'domaines';
    



    public $fillable = [
        'libelle',
        'parent'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'libelle' => 'string',
        'parent' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'libelle' => 'required'
    ];

    
}
