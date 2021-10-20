<?php

namespace App\Modules\Learn\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function getUserAttempts($userId, $quizId)
    {
        return $this->with('quiz')
                    ->where([
                        'user_id' => $userId,
                        'quiz_id' => $quizId
                    ])
                    ->get();
    }

    public function calculateScore($answers, $userAnswers)
    {
        return count($answers) - count(array_diff_assoc($userAnswers, $answers));
    }
}
