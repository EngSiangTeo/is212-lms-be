<?php

namespace Tests\Unit\Assign;

use Tests\TestCase;
use App\Modules\Assign\Models\CourseClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CourseClassTest extends TestCase
{
	use RefreshDatabase, DatabaseMigrations;

	protected $classId = 3;
    protected $noRequirementClassId = 2;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_class_has_requirement()
    {
        $courseRequirements = CourseClass::find($this->classId)->course->requirements->pluck('id')->toArray();

        $this->assertTrue($courseRequirements == [1,]);
    }

    public function test_class_do_not_have_requirement()
    {
		$courseRequirements = CourseClass::find($this->noRequirementClassId)->course->requirements;

        $this->assertTrue($courseRequirements->isEmpty());
    }
}