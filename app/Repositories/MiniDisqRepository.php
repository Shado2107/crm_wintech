<?php

namespace App\Repositories;

use App\Models\MiniDisq;
use App\Repositories\BaseRepository;

/**
 * Class MiniDisqRepository
 * @package App\Repositories
 * @version November 4, 2022, 4:06 pm UTC
*/

class MiniDisqRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'libelle'
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
        return MiniDisq::class;
    }
}
