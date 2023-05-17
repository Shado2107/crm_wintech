<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Challenge
 * @package App\Models
 * @version November 15, 2022, 7:58 pm UTC
 *
 * @property string $title
 * @property unsignedInteger $parcours_formation_id
 */
class Challenge extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'challenges';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'parcours_formation_id',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'parcours_formation_id' => 'required',
        'type' => 'required'
    ];

    
}
