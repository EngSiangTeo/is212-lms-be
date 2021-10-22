<?php

namespace Tests\Unit\Learn;

use Tests\TestCase;
use App\Modules\Learn\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuizTest extends TestCase
{
	use RefreshDatabase, DatabaseMigrations;

	protected $quizId = 1;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_retrieve_quiz_questions()
    {
        $this->assertEquals(Quiz::find($this->quizId)->question->pluck("questions")->toArray(), ["Xerox is the company name","What Xerox does not sell?"]);
    }

    public function test_retrieve_quiz_answers()
    {
        $this->assertEquals(Quiz::find($this->quizId)->question->pluck("answer")->toArray(), ["True","Game"]);
    }
}