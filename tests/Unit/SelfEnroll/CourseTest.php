<?php

namespace Tests\Unit\SelfEnroll;

use Tests\TestCase;
use App\Modules\SelfEnroll\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CourseTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_retrieve_course_requirements()
    {
        $course = new Course();

        $this->assertEquals($course->retrieveCourseRequirements(), [1=>[],2=>[1,],3=>[],4=>[2,3,]]);
    }
}