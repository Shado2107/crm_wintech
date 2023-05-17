<?php

namespace App\Repositories;

use App\Models\PasserTest;
use App\Repositories\BaseRepository;

/**
 * Class PasserTestRepository
 * @package App\Repositories
 * @version November 2, 2022, 2:58 am UTC
*/

class PasserTestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'roue_de_vie_id',
        'mini_disq_id',
        'mini_disc_id',
        'quizz_id',
        'competence_id',
        'user_id',
        'point_id'
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
        return PasserTest::class;
    }
}
