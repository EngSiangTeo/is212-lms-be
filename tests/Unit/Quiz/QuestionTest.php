<?php

namespace Tests\Unit\Quiz;

use Tests\TestCase;
use App\Modules\Quiz\Models\Quiz;
use App\Modules\Quiz\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuestionTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    protected $sectionId = 1;
    
    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_create_True_False_question_for_quiz()
    {
        $quiz = Quiz::Create([
            "duration" => 10,
            "type" => "Ungraded",
            "section_id" => $this->sectionId,
        ]);

        Question::create([
                "questions" => "This statement is True",
                "options" =>json_encode(["True","False"]),
                "answer" => "True",
                "quiz_id" => $quiz->id
        ]);

        $this->assertDatabaseHas('questions', [
            "questions" => "This statement is True",
            "options" => $this->castToJson(json_encode(["True","False"])),
            "answer" => "True",
            "quiz_id" => $quiz->id,
        ]);
    }

    public function test_create_MCQ_question_for_quiz()
    {
        $quiz = Quiz::Create([
            "duration" => 10,
            "type" => "Ungraded",
            "section_id" => $this->sectionId,
        ]);

        Question::create([
                "questions" => "This answer is one",
                "options" =>json_encode(["one","two","three","four"]),
                "answer" => "one",
                "quiz_id" => $quiz->id
        ]);

        $this->assertDatabaseHas('questions', [
            "questions" => "This answer is one",
            "options" => $this->castToJson(json_encode(["one","two","three","four"])),
            "answer" => "one",
            "quiz_id" => $quiz->id,
        ]);
    }
}
