<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Quizz
 * @package App\Models
 * @version November 13, 2022, 7:46 pm UTC
 *
 * @property string $libelle
 * 
 */
class Quizz extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'quizzs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title'
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

    ];

    
}
