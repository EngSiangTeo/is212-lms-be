<?php

namespace App\Modules\SelfEnroll\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Account\User\Models\User;

class UserCourseClass extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function class()
    {
        return $this->belongsTo(CourseClass::class, 'class_id');
    }

    public function checkIfUserEnrollInCourse($userId, $courseId)
    {
        return $this->where(['user_id' => $userId,
                             'course_id' => $courseId
                            ])
                    ->exists();
    }

    public function checkIfLearnerMetRequirement($userId, $requiredCourseId)
    {
        $numberOfRequiredCourseCompleted = $this->where(['user_id' => $userId, 'status' => 'Completed'])
                                                ->whereIn('course_id', $requiredCourseId)
                                                ->count();

        return $numberOfRequiredCourseCompleted == count($requiredCourseId);
    }

    public function retrieveUserEnrolledCourse($userId)
    {
        return $this->where(['user_id' => $userId])
                    ->get()
                    ->pluck('course_id')
                    ->toArray();
    }

    public function retrieveUserCompletedCourse($userId)
    {
        return $this->where(['user_id' => $userId, 'status' => 'Completed'])
                    ->get()
                    ->pluck('course_id')
                    ->toArray();
    }
}
