<?php

namespace App\Modules\Assign\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function enrolled()
    {
        return $this->hasMany(userCourseClass::class, 'course_id', 'id');
    }

    public function requirements()
    {
        return $this->belongsToMany(Course::class, 'course_requirements', 'course_id', 'require_course_id');
    }

    public function classes()
    {
        return $this->hasMany(CourseClass::class, 'course_id', 'id');
    }
}
