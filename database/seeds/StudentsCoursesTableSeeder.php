<?php

use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Database\Seeder;

class StudentsCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $studentsCourses = [];
            $count = 1;

            while ($count <= Course::count()) {
                if ($count <=100){
                    $studentsCourses[] = [
                        "student_id" => rand(0, 99),
                        "course_id" => rand(0, 199),
                    ];
                }

                $studentsCourses[] = [
                    "student_id" => 100,
                    "course_id" => $count,
                ];

                ++$count;
            }

            foreach ($studentsCourses as $studentCourse) {
                if (StudentCourse::where([['course_id', $studentCourse['course_id']],['student_id', $studentCourse['student_id']]])->exists()) {
                    StudentCourse::where(
                        [
                            ['course_id', $studentCourse['course_id']],
                            ['student_id', $studentCourse['student_id']]
                        ]
                    )->update($studentCourse);
                } else {
                    StudentCourse::create($studentCourse);
                }
            }
        }
    }
}
