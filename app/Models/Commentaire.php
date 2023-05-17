<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Commentaire
 * @package App\Models
 * @version November 21, 2022, 3:15 am UTC
 *
 * @property unsignedInteger $video_id
 * @property unsignedInteger $audio_id
 * @property unsignedInteger $article_id
 * @property string $text
 * @property unsignedInteger $user_id
 */
class Commentaire extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'commentaires';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'video_id',
        'audio_id',
        'article_id',
        'user_id',
        'text'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'text' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'text' => 'required',
    ];

    
}
