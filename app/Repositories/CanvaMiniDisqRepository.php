<?php

namespace App\Repositories;

use App\Models\CanvaMiniDisq;
use App\Repositories\BaseRepository;

/**
 * Class CanvaMiniDisqRepository
 * @package App\Repositories
 * @version November 2, 2022, 1:52 am UTC
*/

class CanvaMiniDisqRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'row',
        'column',
        'couleur_id'
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
        return CanvaMiniDisq::class;
    }
}
