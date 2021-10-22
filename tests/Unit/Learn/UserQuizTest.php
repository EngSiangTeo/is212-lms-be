<?php

namespace Tests\Unit\Learn;

use Tests\TestCase;
use App\Modules\Learn\Models\UserQuiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserQuizTest extends TestCase
{
	use RefreshDatabase, DatabaseMigrations;

	protected $quizId = 1;
    protected $userId = 5;
    protected $answers = ["True", "False", "False"];
    protected $userAnswers = ["False", "True", "True"];
    protected $userAnswers2 = ["True", "True", "False"];

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_if_user_attempt_can_be_null()
    {
        $userQuiz = new UserQuiz();
        $this->assertTrue($userQuiz->getUserAttempts($this->userId, $this->quizId)->isEmpty());
    }

    public function test_user_attempt_quiz()
    {
        UserQuiz::Create([
            "user_id" => $this->userId,
            "quiz_id" => $this->quizId,
            "score" => 1,
            "answers" => json_encode($this->userAnswers)
        ]);

        $this->assertDatabaseHas('user_quizzes', [
            "user_id" => $this->userId,
            "quiz_id" => $this->quizId,
            "score" => 1,
            "answers" => $this->castToJson(json_encode($this->userAnswers))
        ]);
    }

    public function test_system_auto_score()
    {
        $userQuiz = new UserQuiz();
        $this->assertEquals($userQuiz->calculateScore($this->answers, $this->userAnswers), 0);
        $this->assertEquals($userQuiz->calculateScore($this->answers, $this->userAnswers2), 2);
    }
}