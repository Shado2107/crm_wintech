<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcours_formation extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $table = 'parcours_formations';

    public $fillable = [
        'libelle',
        'description',
        'prix',
        'duree',
        'win_points',
        'require_credits',
        'formateur_id',
        'parcours_transformation_id'
    ];

     /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'libelle' => 'required',
    //     'duree' => 'required',
    //     'formateur_id' => 'required'
    // ];

}
