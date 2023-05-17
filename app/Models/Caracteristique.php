<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Caracteristique
 * @package App\Models
 * @version November 9, 2022, 9:20 pm UTC
 *
 * @property string $libelle
 * @property unsignedInteger $couleur_id
 */
class Caracteristique extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'caracteristiques';
    

    protected $dates = ['deleted_at'];

    public $fillable = [
        'libelle',
        'couleur_id'
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
        'libelle' => 'required',
        'couleur_id' => 'required'
    ];

    
}
