<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * View all students found in the database
     */
    public function index()
    {
        $students = Student::with('course')->paginate(10);

        return view('view_students', compact(['students']));
    }
}
