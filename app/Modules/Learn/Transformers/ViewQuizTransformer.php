<?php

namespace App\Modules\Learn\Transformers;

use League\Fractal\TransformerAbstract;

class ViewQuizTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['question'];

    public function transform($quiz)
    {
        $quizArray = [
            'quiz_id' => $quiz->id,
            'quiz_duration' => $quiz->duration,
            'quiz_type' => $quiz->type
        ];

        return $quizArray;
    }

    public function includeQuestion($quiz)
    {
        return $this->collection($quiz->question, new QuizQuestionTransformer());
    }
}
