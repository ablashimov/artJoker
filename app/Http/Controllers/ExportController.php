<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportRequest;
use App\Models\Course;
use App\Models\Student;
use App\Services\Csv\CsvExporter;

class ExportController extends Controller
{
    /**
     * Exports student data to a CSV file
     * @param ExportRequest $request
     * @return string
     */
    public function exportStudentsToCSV(ExportRequest $request): string
    {
        $query = Student::query();

        if ($request->all()['data'] != 'all') {
            $query->whereIn('id', $request->all()['data']);
        }

        return (new CsvExporter($query->get()->toArray()))->export();
    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exportCourseAttendanceToCSV()
    {
        $students = Student::query()
            ->has('studentsCourses', '=', Course::query()->count())
            ->get()
            ->toArray();

        return (new CsvExporter($students))->export();
    }
}
