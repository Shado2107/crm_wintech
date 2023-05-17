<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class CanvaMiniDisq
 * @package App\Models
 * @version November 2, 2022, 1:52 am UTC
 *
 * @property integer $row
 * @property integer $column
 * @property integer $couleur_id
 */
class CanvaMiniDisq extends Model
{


    public $table = 'canva_mini_disqs';
    
    public $fillable = [
        'row',
        'column',
        'couleur_id',
        'mini_disq_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'row' => 'integer',
        'column' => 'integer',
        'couleur_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'row' => 'required',
        'column' => 'required',
        'couleur_id' => 'required'
    ];

    
}
