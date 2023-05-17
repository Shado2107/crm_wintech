<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation_accepted extends Model
{
    use HasFactory;


    public $table = 'invitation_accepteds';

    public $fillable = [
        'user_host_id',
        'user_guest_id'
    ];
}  
