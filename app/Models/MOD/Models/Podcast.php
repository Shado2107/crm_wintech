<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Podcast
 * @package App\Models
 * @version January 26, 2023, 12:39 am UTC
 *
 * @property string $libelle
 * @property string $description
 * @property string $podcast
 * @property integer $parcours_formation_id
 * @property integer $formateur_id
 */
class Podcast extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'podcasts';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'libelle',
        'description',
        'podcast',
        'parcours_formation_id',
        'formateur_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'libelle' => 'string',
        'description' => 'string',
        'podcast' => 'string',
        'parcours_formation_id' => 'integer',
        'formateur_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'libelle' => 'required',
        'description' => 'required',
        'podcast' => 'required',
        'parcours_formation_id' => 'required'
    ];

    protected $hidden = [
        'formateur_id'
    ];
    
}
