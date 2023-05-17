<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Citation
 * @package App\Models
 * @version November 29, 2022, 12:43 am UTC
 *
 * @property string $content
 * @property unsignedInteger $parcours_formation_id
 */
class Citation extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'citations';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'content',
        'name_author',
        'parcours_formation_id',
        'challenge_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'content' => 'required',
        'parcours_formation_id' => 'required'
    ];


    protected $hidden = [
        'formateur_id',
    ];
    
}
