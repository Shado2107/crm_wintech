<?php

namespace App\Repositories;

use App\Models\Domaine;
use App\Repositories\BaseRepository;

/**
 * Class DomaineRepository
 * @package App\Repositories
 * @version November 2, 2022, 3:11 am UTC
*/

class DomaineRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'libelle',
        'parent'
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
        return Domaine::class;
    }
}
