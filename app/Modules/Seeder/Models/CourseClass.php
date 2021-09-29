<?php

namespace App\Modules\Seeder\Models;

use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    /**
     * The table associated with the model.
     *
     * By convention, the "snake case", plural name of the class will be used as the table name unless another name is explicitly specified
     *
     * @var string
     */
    protected $table = 'classes';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
