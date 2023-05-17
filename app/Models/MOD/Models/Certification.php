<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parcours_formation_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function parcours_formation()
    {
        return $this->belongsTo('App\Models\Parcours_formation');
    }
}
