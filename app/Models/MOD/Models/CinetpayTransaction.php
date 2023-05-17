<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinetpayTransaction extends Model
{
    public $table = 'cinetpay_transactions';

    use HasFactory;

    public $fillable = [
        'user_id',
        'parcours_id'
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
