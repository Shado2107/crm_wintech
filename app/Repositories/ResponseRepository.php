<?php

namespace App\Repositories;

use App\Models\Reponse;
use App\Repositories\BaseRepository;

/**
 * Class ResponseRepository
 * @package App\Repositories
 * @version November 4, 2022, 5:12 pm UTC
*/

class ResponseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'valeur',
        'question_id',
        'bonne_response'
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
        return Response::class;
    }
}
