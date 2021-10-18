<?php

namespace App\Modules\Learn\Models;

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

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function section()
    {
        return $this->hasMany(Section::class, 'class_id', 'id');
    }
}
