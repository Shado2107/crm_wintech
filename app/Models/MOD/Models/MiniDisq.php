<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class MiniDisq
 * @package App\Models
 * @version November 4, 2022, 4:06 pm UTC
 *
 * @property string $libelle
 */
class MiniDisq extends Model
{


    public $table = 'mini_disqs';
    



    public $fillable = [
        'libelle'
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
        'libelle' => 'required'
    ];

    
}
