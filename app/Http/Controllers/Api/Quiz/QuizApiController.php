<?php

namespace App\Http\Controllers\Api\Quiz;

use Spatie\Fractal\Fractal;
use Illuminate\Http\Request;
use App\Modules\Quiz\Models\Quiz;
use App\Modules\Quiz\Models\Section;
use App\Modules\Quiz\Models\Question;
use App\Modules\Quiz\Models\CourseClass;
use Spatie\Fractalistic\ArraySerializer;
use App\Modules\Account\User\Models\User;
use App\Http\Controllers\Api\ApiController;

/**
* @group Quiz endpoints
*/
class QuizApiController extends ApiController
{
    public function createQuizForSection($sectionId, Request $request)
    {
        $section = Section::find($sectionId);

        if ($section->quiz) {
            return $this->respondError('Quiz already created for section', 406);
        }

        $quizDuration = $request['duration'];
        $quizType = $request['type'];

        $quiz = Quiz::Create([
            "duration" => $quizDuration,
            "type" => $quizType,
            "section_id" => $sectionId,
        ]);

        return $this->respondSuccess($quiz, 'Successfully created quiz');
    }

    public function createQuestionForSection($sectionId, Request $request)
    {
        $section = Section::find($sectionId);

        if (!$section->quiz) {
            return $this->respondError('Quiz not created for section yet', 406);
        }

        $questions = $request['questions'];

        foreach ($questions as $question) {
            Question::create([
                "questions" => $question['questions'],
                "options" =>json_encode($question['options']),
                "answer" => $question['answer'],
                "quiz_id" => $section->quiz->id
            ]);
        }

        return $this->respondSuccess($questions, 'Successfully created quiz');
    }

    public function viewTrainerCourse($userId)
    {
        $courseClass = new CourseClass();

        $assignedClass = $courseClass->getAllClassesAssigned($userId);

        return $this->respondSuccess($assignedClass, 'Successfully retrieved assigned classes');
    }
}
