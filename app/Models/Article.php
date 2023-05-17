<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Article
 * @package App\Models
 * @version November 10, 2022, 11:40 pm UTC
 *
 * @property string $libelle
 * @property string $description
 * @property string $content
 * @property unsignedInteger $parcours_formation_id
 */
class Article extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'articles';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'libelle',
        'content',
        'link',
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
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'libelle' => 'required',
        'content' => 'required',
        'parcours_formation_id' => 'required'
    ];

    
}
