<?php

namespace Tests\Unit\Learn;

use Tests\TestCase;
use App\Modules\Learn\Models\CourseClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CourseClassTest extends TestCase
{
	use RefreshDatabase, DatabaseMigrations;

	protected $classId = 1;
    protected $nullTrainerClassId = 4;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_retrieve_class_trainer()
    {
        $this->assertEquals(CourseClass::find($this->classId)->trainer->id, 2);
    }

    public function test_if_class_trainer_can_be_null()
    {
        $this->assertEquals(CourseClass::find($this->nullTrainerClassId)->trainer, null);
    }

    public function test_retrieve_section()
    {
        $this->assertEquals(CourseClass::find($this->classId)->section->first()->id, 1);
    }
}