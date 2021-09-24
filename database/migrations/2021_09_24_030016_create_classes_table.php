<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id');
            $table->foreignId('trainer_id');
            $table->time('starttime');
            $table->time('endtime');
            $table->date('startdate');
            $table->date('startend');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('trainer_id')->references('id')->on('users');
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
        Schema::dropIfExists('classes');
    }
}
