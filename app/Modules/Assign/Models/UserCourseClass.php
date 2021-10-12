<?php

namespace App\Modules\Assign\Models;

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

    public function getEnrolledUsers($courseId)
    {
        return $this->with('user')
                    ->where('course_id', '=', $courseId)
                    ->get()
                    ->pluck('user');
    }

    public function getLearnersWithRequirement($requiredCourseId)
    {
        return $this->with('user')
                   ->where(['status' => 'Completed'])
                   ->whereIn('course_id', $requiredCourseId)
                   ->groupBy('user_id')
                   ->having(DB::raw('count(*)'), '=', count($requiredCourseId))
                   ->get()
                   ->pluck('user');
    }

    public function checkIfUserEnrollInClass($userId, $classId)
    {
        return $this->where(['user_id' => $userId,
                             'class_id' => $classId
                             ])
                    ->exists();
    }

    public function checkIfUserEnrollInCourse($userId, $courseId)
    {
        return $this->where(['user_id' => $userId,
                             'course_id' => $courseId
                            ])
                    ->exists();
    }

    public function withdrawLearner($userId, $classId)
    {
        return $this->where(['user_id'=>$userId, 'class_id'=>$classId])
                    ->delete();
    }

    public function checkIfLearnerMetRequirement($userId, $requiredCourseId)
    {
        $numberOfRequiredCourseCompleted = $this->where(['user_id' => $userId, 'status' => 'Completed'])
                                                ->whereIn('course_id', $requiredCourseId)
                                                ->count();

        return $numberOfRequiredCourseCompleted == count($requiredCourseId);
    }
}
