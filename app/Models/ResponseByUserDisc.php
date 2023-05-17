<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;



/**
 * Class ResponseByUserDisc
 * @package App\Models
 * @version November 4, 2022, 5:43 pm UTC
 *
 * @property integer $row
 * @property integer $column
 * @property integer $point
 * @property unsignedInteger $user_id
 */
class ResponseByUserDisc extends Model
{


    public $table = 'response_by_user_discs';
    



    public $fillable = [
        'row',
        'column',
        'point',
        'user_id',
        'passer_test_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'row' => 'integer',
        'column' => 'integer',
        'point' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'row_id' => 'required',
        'points' => 'required',
        'passer_test_id' => 'required'
    ];

    
}
