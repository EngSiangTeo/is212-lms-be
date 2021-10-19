<?php

namespace App\Http\Controllers\Api\Learn;

use Spatie\Fractal\Fractal;
use Illuminate\Http\Request;
use App\Modules\Learn\Models\Course;
use App\Modules\Learn\Models\Section;
use App\Modules\Learn\Models\Material;
use App\Modules\Learn\Models\UserQuiz;
use Spatie\Fractalistic\ArraySerializer;
use App\Modules\Learn\Models\CourseClass;
use App\Modules\Account\User\Models\User;
use App\Http\Controllers\Api\ApiController;
use App\Modules\Learn\Models\UserCourseClass;
use App\Modules\Learn\Transformers\TakeClassTransformer;

/**
* @group Learn endpoints
*/
class TakeCourseApiController extends ApiController
{
    public function viewCourseMaterial($userId, $classId)
    {
        $userCourseClass = new UserCourseClass();

        if (!$userCourseClass->checkIfUserEnrollInClass($userId, $classId)) {
            return $this->respondError('You do not have permission to view this course', 403);
        }

        $class = CourseClass::with('course', 'trainer', 'section', 'section.material')
                            ->find($classId);

        $class = Fractal($class, new TakeClassTransformer())
                        ->serializeWith(new ArraySerializer())
                        ->toArray();

        return $this->respondSuccess($class, 'Successfully retrieved course materials');
    }

    public function takeQuizAssessment($userId, $sectionId, Request $request)
    {
        $section = Section::find($sectionId);

        if (!$section->quiz) {
            return $this->respondError('Quiz not found', 404);
        }

        $userAnswers = $request['answers'];
        $userScore = 0;
        $question = $section->quiz->question;

        for ($i = 0; $i < count($question); $i++) {
            if ($question[$i]->answer == $userAnswers[$i]) {
                $userScore += 1;
            }
        }

        $userQuiz = UserQuiz::Create([
            "user_id" => $userId,
            "quiz_id" => $section->quiz->id,
            "score" => $userScore,
            "answers" => json_encode($userAnswers)
        ]);

        return $this->respondSuccess($userQuiz, 'Successfully submitted quiz');
    }

    public function viewQuizScoreAndAnswer($userId, $attemptId)
    {
        $userAttempt = UserQuiz::find($attemptId);

        if (!$userAttempt) {
            return $this->respondError('Quiz attempt not found', 404);
        }

        if ($userId != $userAttempt->user_id) {
            return $this->respondError('You do not have permission to view this', 403);
        }

        if ($userAttempt->quiz->type != "Ungraded") {
            return $this->respondError('You do not have permission to view this', 403);
        }

        $payload['userAnswers'] = json_decode($userAttempt->answers);
        $payload['answers'] = $userAttempt->quiz->question->pluck('answer');
        $payload['score'] = $userAttempt->score;
        $payload['total'] = count($userAttempt->quiz->question);

        return $this->respondSuccess($payload, 'Successfully retrieved quiz attempt');
    }
}
