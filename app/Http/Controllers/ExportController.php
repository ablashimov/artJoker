<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportRequest;
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
        $students = Student::query()->whereIn('id', $request->all()['studentsId'])->get()->toArray();

        return (new CsvExporter($students))->export();
    }

    public function exportAllStudentsToCSV(): string
    {
        $students = Student::query()->get()->toArray();

        return (new CsvExporter($students))->export();
    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exportCourseAttendanceToCSV()
    {

    }
}
