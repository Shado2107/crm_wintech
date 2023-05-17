<?php

namespace App\Repositories;

use App\Models\Points;
use App\Repositories\BaseRepository;

/**
 * Class PointsRepository
 * @package App\Repositories
 * @version November 2, 2022, 2:55 am UTC
*/

class PointsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'value'
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
        return Points::class;
    }
}
