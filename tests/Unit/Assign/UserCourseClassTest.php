<?php

namespace Tests\Unit\Assign;

use Tests\TestCase;
use App\Modules\Assign\Models\UserCourseClass;
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
    public function test_enroll_user()
    {
        $userCourseClass = UserCourseClass::Create([
                                                "user_id" => $this->enrollUserId,
                                                "course_id" => $this->courseId,
                                                "class_id" => $this->classId,
                                                "status" => "Enrolled"
                                            ]);

        $this->assertDatabaseHas('user_course_classes', [
            "user_id" => $this->enrollUserId,
            "course_id" => $this->courseId,
            "class_id" => $this->classId,
            "status" => "Enrolled"
        ]);
    }

    public function test_if_user_enrolled_in_class()
    {
        $userCourseClass = new UserCourseClass();

        $this->assertTrue($userCourseClass->checkIfUserEnrollInClass($this->userId, $this->classId));
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
                                                "status" => "Enrolled"
                                            ]);

        $userCourseClass = new UserCourseClass();

        $this->assertTrue(!$userCourseClass->checkIfLearnerMetRequirement($this->enrollUserId, $this->courseRequirement));
    }

    public function test_if_user_met_requirement()
    {
        $userCourseClass = new UserCourseClass();

        $this->assertTrue($userCourseClass->checkIfLearnerMetRequirement($this->userId, $this->courseRequirement));
    }


    /**
     * Test if we can withdraw user
     *
     * @return void
     */
    public function test_withdraw_user()
    {
        $userCourseClass = new UserCourseClass();
        $userCourseClass->withdrawLearner($this->userId, $this->classId);

        $this->assertDatabaseMissing('user_course_classes', [
            "user_id" => $this->userId,
            "course_id" => $this->courseId,
            "class_id" => $this->classId
        ]);
    }

    public function test_if_user_not_enrolled_in_class()
    {
        $userCourseClass = new UserCourseClass();
        $userCourseClass->withdrawLearner($this->userId, $this->classId);

        $this->assertTrue(!$userCourseClass->checkIfUserEnrollInClass($this->userId, $this->classId));
    }

    public function test_if_user_not_enrolled_in_course()
    {
        $userCourseClass = new UserCourseClass();
        $userCourseClass->withdrawLearner($this->userId, $this->classId);

        $this->assertTrue(!$userCourseClass->checkIfUserEnrollInCourse($this->userId, $this->courseId));
    }
}
