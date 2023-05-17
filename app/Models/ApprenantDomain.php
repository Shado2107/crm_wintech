<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ApprenantDomain
 * @package App\Models
 * @version November 7, 2022, 12:52 am UTC
 *
 * @property unsignedInteger $apprenant_id
 * @property required $domain_id
 */
class ApprenantDomain extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'apprenant_domains';
    

    protected $dates = ['deleted_at'];

    public $fillable = [
        'apprenant_id',
        'domain_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'passer_test_id' => 'required'
    ];

    
}
