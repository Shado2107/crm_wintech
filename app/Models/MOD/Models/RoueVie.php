<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class RoueVie
 * @package App\Models
 * @version November 6, 2022, 3:13 pm UTC
 *
 * @property string $libelle
 */
class RoueVie extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'roue_vies';
    

    protected $dates = ['deleted_at'];



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
