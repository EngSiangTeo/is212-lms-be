<?php

namespace App\Http\Controllers\Api\SelfEnroll;

use Spatie\Fractal\Fractal;
use Illuminate\Http\Request;
use Spatie\Fractalistic\ArraySerializer;
use App\Modules\Account\User\Models\User;
use App\Modules\SelfEnroll\Models\Course;
use App\Http\Controllers\Api\ApiController;
use App\Modules\SelfEnroll\Models\CourseClass;
use App\Modules\SelfEnroll\Models\UserCourseClass;
use App\Modules\SelfEnroll\Transformers\AvailableCourseTransformer;

/**
* @group Self Enroll endpoints
*/
class SelfEnrollApiController extends ApiController
{
    public function getListOfAvailableClasses($userId)
    {
        $courses = Course::with('classes', 'classes.trainer')
                           ->get();

        $enrolledCourseId = UserCourseClass::where(['user_id' => $userId])
                                           ->get()
                                           ->pluck('course_id')
                                           ->toArray();

        $completedCourseId = UserCourseClass::where(['user_id' => $userId, 'status' => 'Completed'])
                                           ->get()
                                           ->pluck('course_id')
                                           ->toArray();

        $courseRequirements = Course::with('requirements')
                                      ->get()
                                      ->pluck('requirements.*.id', 'id')
                                      ->toArray();

        foreach ($courses as $course) {
            $courseId = $course->id;
            if (in_array($courseId, $enrolledCourseId)) {
                $course->enrollabled = false;
                $course->reason = "You have already enrolled in the course";
            } elseif (!empty($courseRequirements[$courseId])) {
                if (array_intersect($courseRequirements[$courseId], $completedCourseId) == $courseRequirements[$courseId]) {
                    $course->enrollabled = true;
                } else {
                    $course->enrollabled = false;
                    $course->reason = "You do not meet the course requirements";
                }
            } else {
                $course->enrollabled = true;
            }
        }

        $courses = Fractal($courses, new AvailableCourseTransformer())
                        ->serializeWith(new ArraySerializer())
                        ->toArray();

        return $this->respondSuccess($courses, 'Successfully retrieved classes');
    }
}
