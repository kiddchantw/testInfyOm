<?php

namespace App\Repositories;

use App\Models\Technician;
use App\Repositories\BaseRepository;

/**
 * Class TechnicianRepository
 * @package App\Repositories
 * @version December 29, 2021, 7:24 pm UTC
*/

class TechnicianRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'age'
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
        return Technician::class;
    }
}
