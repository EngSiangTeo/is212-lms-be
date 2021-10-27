<?php

namespace App\Modules\Learn\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Account\User\Models\User;

class UserCourseClass extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function class()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }

    public function checkIfUserEnrollInClass($userId, $classId)
    {
        return $this->where(['user_id' => $userId,
                             'class_id' => $classId
                             ])
                    ->exists();
    }

    public function getAllClassesUserEnrolled($userId)
    {
        return $this->with('class', 'course')
                    ->where(['user_id' => $userId])
                    ->whereIn('status', ['Completed', 'Enrolled'])
                    ->get();
    }
}
