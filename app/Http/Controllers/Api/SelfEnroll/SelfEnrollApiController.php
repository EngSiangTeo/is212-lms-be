<?php

namespace App\Http\Controllers\Api\SelfEnroll;

use Carbon\Carbon;
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
        $courses = Course::with(['classes' => function ($query) {
                                $query->where('enroll_start_date', '<=', Carbon::now()->toDateTimeString())
                                    ->where('enroll_end_date', '>=', Carbon::now()->toDateTimeString());
        }, 'classes.trainer', 'classes.enrolled' => function ($query) {
             $query->whereIn('status', ['Enrolled','Completed']);
        }, 'requirements'])
                           ->get();

        $userCourseClass = new UserCourseClass();

        $enrolledCourseId = $userCourseClass->retrieveUserEnrolledCourse($userId);

        $completedCourseId = $userCourseClass->retrieveUserCompletedCourse($userId);

        $course = new Course();

        $courseRequirements = $course->retrieveCourseRequirements();

        foreach ($courses as $course) {
            $courseId = $course->id;
            if (in_array($courseId, $enrolledCourseId)) {
                $course->enrollabled = false;
                $course->reason = "You have already enrolled/applied in the course. Please check with the HR department regarding your application.";
            } elseif (!empty($courseRequirements[$courseId])) {
                if (array_intersect($courseRequirements[$courseId], $completedCourseId) == $courseRequirements[$courseId]) {
                    $course->enrollabled = true;
                } else {
                    $course->enrollabled = false;
                    $course->reason = "You do not meet the course requirements.";
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

    public function applyToClass($classId, $userId)
    {
        $selectedCourse = CourseClass::find($classId)->course;

        $userCourseClass = new UserCourseClass();
        #check if user already enrolled
        if ($userCourseClass->checkIfUserEnrollInCourse($userId, $selectedCourse->id)) {
            return $this->respondError('You already enrolled/applied in similar course', 406);
        }

        #check if user meet requirement
        if (!$selectedCourse->requirements->isEmpty()) {
            $requiredCourseId = $selectedCourse->requirements->pluck('id');
            if (!$userCourseClass->checkIfLearnerMetRequirement($userId, $requiredCourseId)) {
                return $this->respondError('You does not meet this course requirement', 406);
            }
        }

        #create new user course class
        $userCourseClass = UserCourseClass::Create([
            "user_id" => $userId,
            "course_id" => $selectedCourse->id,
            "class_id" => $classId,
            "status" => "Applied"
        ]);

        return $this->respondCreated($userCourseClass, 'Successfully applied for class');
    }
}
