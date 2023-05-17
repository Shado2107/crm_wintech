<?php

namespace App\Repositories;

use App\Models\Apprenant;
use App\Repositories\BaseRepository;

/**
 * Class ApprenantRepository
 * @package App\Repositories
 * @version October 28, 2022, 12:16 am UTC
*/

class ApprenantRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'couleur_id',
        'telephone',
        'whatsapp'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Apprenant::class;
    }
}
