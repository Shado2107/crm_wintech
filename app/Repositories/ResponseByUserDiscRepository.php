<?php

namespace App\Repositories;

use App\Models\ResponseByUserDisc;
use App\Repositories\BaseRepository;

/**
 * Class ResponseByUserDiscRepository
 * @package App\Repositories
 * @version November 4, 2022, 5:43 pm UTC
*/

class ResponseByUserDiscRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'row',
        'column',
        'point',
        'user_id'
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
        return ResponseByUserDisc::class;
    }
}
