<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="Technician",
 *      required={"id", "name", "age"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="age",
 *          description="age",
 *          type="string"
 *      )
 * )
 */
class Technician extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'technicians';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'name',
        'age'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'age' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required',
        'name' => 'required',
        'age' => 'required'
    ];

    
}
