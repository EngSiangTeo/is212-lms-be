<?php

namespace Tests\Unit\Learn;

use Tests\TestCase;
use App\Modules\Learn\Models\UserCourseClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCourseClassTest extends TestCase
{
    use DatabaseMigrations;

    protected $userId = 6;
    protected $classId = 1;

    public function setUp(): void
    {
        parent::setUp();
        // seed the database
        $this->artisan('db:seed');
    }

    public function test_if_user_enrolled_in_class()
    {
        $userCourseClass = new UserCourseClass();

        $this->assertTrue($userCourseClass->checkIfUserEnrollInClass($this->userId, $this->classId));
    }
} 