<?php

namespace Tests\Unit\Quiz;

use Tests\TestCase;
use App\Modules\Quiz\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SectionTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    protected $sectionId = 2;
    
    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_section_quiz_not_create_yet()
    {
        $this->assertEquals(Section::find($this->sectionId)->quiz, null);
    }

    public function get_class_from_section()
    {
        $this->assertEquals(Section::find($this->sectionId)->class->id, 1);
    }
}
