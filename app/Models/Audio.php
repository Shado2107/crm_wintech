<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Audio
 * @package App\Models
 * @version November 10, 2022, 11:34 pm UTC
 *
 * @property string $libelle
 * @property string $description
 * @property string $podcast
 * @property unsignedInteger $parcours_formation_id
 */
class Audio extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'audios';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'libelle',
        'description',
        'podcast',
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
        'podcast' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'libelle' => 'required',
        'podcast' => 'required',
        'parcours_formation_id' => 'required'
    ];

    
}
