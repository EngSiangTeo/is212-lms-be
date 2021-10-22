<?php

namespace Tests\Unit\SelfEnroll;

use Tests\TestCase;
use App\Modules\SelfEnroll\Models\UserCourseClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCourseClassTest extends TestCase
{
    use DatabaseMigrations;

    protected $userId = 6;
    protected $enrollUserId = 5;
    protected $courseId = 1;
    protected $classId = 1;
    protected $courseRequirement = [1,];

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }
    
    /**
     * Test if we can enroll user
     *
     * @return void
     */
    public function test_user_self_enrol()
    {
        $userCourseClass = UserCourseClass::Create([
                                                "user_id" => $this->enrollUserId,
                                                "course_id" => $this->courseId,
                                                "class_id" => $this->classId,
                                                "status" => "Applied"
                                            ]);

        $this->assertDatabaseHas('user_course_classes', [
            "user_id" => $this->enrollUserId,
            "course_id" => $this->courseId,
            "class_id" => $this->classId,
            "status" => "Applied"
        ]);
    }

    public function test_if_user_enrolled_in_course()
    {
        $userCourseClass = new UserCourseClass();

        $this->assertTrue($userCourseClass->checkIfUserEnrollInCourse($this->userId, $this->courseId));
    }

    public function test_if_user_not_met_requirement()
    {
        $userCourseClass = UserCourseClass::Create([
                                                "user_id" => $this->enrollUserId,
                                                "course_id" => $this->courseId,
                                                "class_id" => $this->classId,
                                                "status" => "Applied"
                                            ]);

        $userCourseClass = new UserCourseClass();

        $this->assertTrue(!$userCourseClass->checkIfLearnerMetRequirement($this->enrollUserId, $this->courseRequirement));
    }

    public function test_if_user_met_requirement()
    {
        $userCourseClass = new UserCourseClass();

        $this->assertTrue($userCourseClass->checkIfLearnerMetRequirement($this->userId, $this->courseRequirement));
    }

    public function test_retrieve_user_enrolled_course()
    {
        $userCourseClass = new UserCourseClass();

        $this->assertEquals($userCourseClass->retrieveUserEnrolledCourse($this->userId), [1,2,3,4,]);
    }

    public function test_retrieve_user_completed_course()
    {
        $userCourseClass = new UserCourseClass();

        $this->assertEquals($userCourseClass->retrieveUserCompletedCourse($this->userId),[1,2,3,]);
    }
}
