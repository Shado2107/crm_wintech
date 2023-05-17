<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Citation
 * @package App\Models
 * @version November 29, 2022, 12:43 am UTC
 *
 * @property string $content
 * @property unsignedInteger $parcours_formation_id
 */
class Competence extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'competences';
    

   

    
}
