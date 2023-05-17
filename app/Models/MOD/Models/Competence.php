<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Competence
 * @package App\Models
 * @version January 19, 2023, 1:56 am UTC
 *
 * @property string $type
 * @property string $content
 */
class Competence extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'competences';
    

    protected $dates = ['deleted_at'];

    
    public $fillable = [
        'type',
        'content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required',
        'content' => 'required'
    ];

    
}
