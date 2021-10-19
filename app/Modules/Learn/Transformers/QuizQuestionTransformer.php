<?php

namespace App\Modules\Learn\Transformers;

use League\Fractal\TransformerAbstract;

class QuizQuestionTransformer extends TransformerAbstract
{
    public function transform($question)
    {
        $questionArray = [
            'question_id' => $question->id,
            'question_name' => $question->questions,
            'options' => json_decode($question->options)
        ];

        return $questionArray;
    }
}
