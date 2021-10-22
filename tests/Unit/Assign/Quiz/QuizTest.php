<?php

namespace Tests\Unit\Quiz;

use Tests\TestCase;
use App\Modules\Quiz\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class QuizTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    protected $sectionId = 2;
    
    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_create_quiz_for_section()
    {
        Quiz::Create([
            "duration" => 10,
            "type" => "Ungraded",
            "section_id" => $this->sectionId,
        ]);

        $this->assertDatabaseHas('quizzes', [
            "duration" => 10,
            "type" => "Ungraded",
            "section_id" => $this->sectionId,
        ]);
    }
}
