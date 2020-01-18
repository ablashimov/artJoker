<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * View all students found in the database
     */
    public function index(): View
    {
        $students = Student::with(['courses','address'])->paginate(20);

        return view('view_students', compact('students'));
    }
}
