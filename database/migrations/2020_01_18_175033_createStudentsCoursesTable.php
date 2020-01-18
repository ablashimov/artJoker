<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_courses', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('course_id');
            $table->unique(['student_id','course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('students_courses');
    }
}
