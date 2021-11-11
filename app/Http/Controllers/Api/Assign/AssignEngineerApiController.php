<?php

namespace App\Http\Controllers\Api\Assign;

use Spatie\Fractal\Fractal;
use Illuminate\Http\Request;
use App\Modules\Assign\Models\Course;
use Spatie\Fractalistic\ArraySerializer;
use App\Modules\Account\User\Models\User;
use App\Modules\Assign\Models\CourseClass;
use App\Http\Controllers\Api\ApiController;
use App\Modules\Assign\Models\UserCourseClass;
use App\Modules\Assign\Transformers\LearnerTransformer;
use App\Modules\Assign\Transformers\CourseClassTransformer;

/**
* @group Assign endpoints
*/
class AssignEngineerApiController extends ApiController
{
    public function getEnrollableLearners($classId)
    {
        $selectedCourse = CourseClass::find($classId)->course;

        $userCourseClass = new UserCourseClass();
        $enrolledLearners = $userCourseClass->getEnrolledUsers($selectedCourse->id);

        if ($selectedCourse->requirements->isEmpty()) {
            $learners = User::where(['role' => 'learner'])->get();

            $availableStudents = $learners->diff($enrolledLearners);
        } else {
            $requiredCourseId = $selectedCourse->requirements->pluck('id');

            $clearedStudents = $userCourseClass->getLearnersWithRequirement($requiredCourseId);

            $availableStudents = $clearedStudents->diff($enrolledLearners);
        }

        $payload['learners'] = Fractal($availableStudents, new LearnerTransformer())
                                    ->serializeWith(new ArraySerializer())
                                    ->toArray();

        return $this->respondSuccess($payload, 'Successfully retrieved learners');
    }

    public function enrollLearners($classId, $userId)
    {
        $selectedCourse = CourseClass::find($classId)->course;

        $userCourseClass = new UserCourseClass();
        #check if user already enrolled
        if ($userCourseClass->checkIfUserEnrollInCourse($userId, $selectedCourse->id)) {
            return $this->respondError('User already enrolled in similar course', 406);
        }

        #check if user meet requirement
        if (!$selectedCourse->requirements->isEmpty()) {
            $requiredCourseId = $selectedCourse->requirements->pluck('id');
            if (!$userCourseClass->checkIfLearnerMetRequirement($userId, $requiredCourseId)) {
                return $this->respondError('User does not meet this course requirement', 406);
            }
        }

        #create new user course class
        $userCourseClass = UserCourseClass::Create([
            "user_id" => $userId,
            "course_id" => $selectedCourse->id,
            "class_id" => $classId,
            "status" => "Enrolled"
        ]);

        return $this->respondCreated($userCourseClass, 'Successfully enrolled leaners');
    }

    public function withdrawLearnerFromClass($classId, $userId)
    {
        $userCourseClass = new UserCourseClass();

        if ($userCourseClass->checkIfUserEnrollInClass($userId, $classId)) {
            $payload['user_id'] = $userId;
            $payload['class_id'] = $classId;
            $userCourseClass->withdrawLearner($userId, $classId);
            return $this->respondSuccess($payload, 'Sucessfully withdrew learner');
        } else {
            return $this->respondNotFound('Record does not exist');
        }
    }

    public function getEnrolledUsersInClass($classId)
    {
        $enrolledLearners = CourseClass::with('enrolled.user', 'course')
                                         ->find($classId);

        $enrolledLearners = Fractal($enrolledLearners, new CourseClassTransformer())
                                    ->serializeWith(new ArraySerializer())
                                    ->toArray();
        return $this->respondSuccess($enrolledLearners, 'Successfully retrieved enrolled learners');
    }

    public function getListOfAllClasses()
    {
        $classes = Course::with('classes', 'classes.trainer')
                           ->get();

        return $this->respondSuccess($classes, 'Successfully retrieved classes');
    }

    public function setClassTrainer($classId, $userId)
    {
        $user = User::find($userId);

        if ($user->role != "Trainer") {
            return $this->respondError('User is not a trainer', 406);
        }

        $class = CourseClass::find($classId);
        $class->trainer_id = $userId;
        $class->save();
        return $this->respondSuccess($class->fresh(), 'Successfully assigned trainer');
    }

    public function getTrainerList($classId)
    {
        $class = CourseClass::with('course','trainer')
                            ->find($classId);

        $trainers = User::select('id', 'name', 'email')
                        ->where(['role' => 'trainer'])
                        ->where('id', "<>", $class->trainer_id)
                        ->get();

        $class->trainer_list = $trainers;

        return $this->respondSuccess($class, 'Successfully retrieved trainers');
    }

    public function updateUserEnroll($classId, $userId, $status)
    {
        $enrollRecord = UserCourseClass::where(['class_id' => $classId,
                                                'user_id' => $userId]);

        $enrollRecord->update(['status' => $status]);

        return $this->respondSuccess($enrollRecord->get(), 'Successfully updated records');
    }
}
