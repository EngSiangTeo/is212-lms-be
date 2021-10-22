<?php

namespace Tests\Unit\Learn;

use Tests\TestCase;
use App\Modules\Learn\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SectionTest extends TestCase
{
	use RefreshDatabase, DatabaseMigrations;

	protected $sectionId = 1;
    protected $nullQuizSectionId = 2;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_retrieve_section_material()
    {
        $this->assertEquals(Section::find($this->sectionId)->material->first()->file_url, "https://spm-course-materials.s3.amazonaws.com/Introduction+to+Xerox+1.pptx");
    }

    public function test_retrieve_section_quiz()
    {
        $this->assertEquals(Section::find($this->sectionId)->quiz->id, 1);
    }

    public function test_if_section_quiz_can_be_null()
    {
        $this->assertEquals(Section::find($this->nullQuizSectionId)->quiz, null);
    }
}