<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ApprenantCompetence
 * @package App\Models
 * @version January 19, 2023, 1:34 am UTC
 *
 * @property apprenant_id $unsignedInteger
 * @property competence_id $unsignedInteger
 * @property integer $state
 */
class ApprenantCompetence extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'apprenant_competences';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'apprenant_id',
        'competence_id',
        'state'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'state' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'apprenant_id' => 'required',
        'competence_id' => 'required'
    ];

    
}
