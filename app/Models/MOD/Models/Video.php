<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Video
 * @package App\Models
 * @version November 10, 2022, 11:08 pm UTC
 *
 * @property string $libelle
 * @property string $description
 * @property string $source
 * @property unsignedInteger $parcours_formation_id
 */
class Video extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'videos';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'libelle',
        'description',
        'source',
        'parcours_formation_id',
        'quizz_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'libelle' => 'string',
        'description' => 'string',
        'source' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'libelle' => 'required',
        'description' => 'required',
        'source' => 'required',
        'parcours_formation_id' => 'required'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'formateur_id'
    ];

    
}
