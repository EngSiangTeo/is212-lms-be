<?php

namespace App\Http\Controllers\Api\Quiz;

use Spatie\Fractal\Fractal;
use Illuminate\Http\Request;
use App\Modules\Quiz\Models\Section;
use App\Modules\Quiz\Models\Quiz;
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
}
