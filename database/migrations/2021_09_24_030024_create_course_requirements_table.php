<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id');
            $table->foreignId('require_course_id');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('require_course_id')->references('id')->on('courses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_requirements');
    }
}
