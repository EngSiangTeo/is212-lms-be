<?php

namespace App\Modules\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Account\User\Models\User;

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
}
