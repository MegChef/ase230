<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

/**
 * Student Web Controller - Using Views (Lesson 6)
 * 
 * Evolution from Lesson 5:
 * ❌ BEFORE: Returned HTML strings directly
 * ✅ NOW: Returns Blade views with proper templating
 * 
 * Key Teaching Points:
 * 1. Separation of Concerns - Logic vs Presentation
 * 2. Blade Templates - Reusable, maintainable views
 * 3. Flash Messages - User feedback system
 * 4. Form Validation - Proper error handling in views
 * 5. Layout Inheritance - DRY principle in views
 */
class StudentController extends Controller
{
    /**
     * Display all students
     * GET /students
     * 
     * EVOLUTION:
     * Before: return $html; (HTML string concatenation)
     * Now: return view('students.index', compact('students'));
     */
    public function index()
    {
        // Query database to get all students
        $students = Student::all();
        
        // Return Blade view with data
        return view('students.index', compact('students'));
    }

    /**
     * Show form to create new student
     * GET /students/create
     * 
     * EVOLUTION:
     * Before: return '<form>...</form>'; (HTML string)
     * Now: return view('students.create');
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store new student in database
     * POST /students
     * 
     * EVOLUTION:
     * Before: return '<h1>Success!</h1>...'; (HTML string)
     * Now: return redirect()->with('success', 'Message');
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'major' => 'required|string|max:255',
            'year' => 'required|integer|min:1|max:4'
        ]);

        // Create student in database
        Student::create($validated);
        
        // Redirect with flash message (better UX than HTML string)
        return redirect()->route('students.index')
                        ->with('success', 'Student created successfully!');
    }

    /**
     * Display specific student
     * GET /students/{student}
     * 
     * EVOLUTION:
     * Before: return '<h1>Student Details</h1>...'; (HTML string)
     * Now: return view('students.show', compact('student'));
     */
    public function show(Student $student)
    {
        // Laravel automatically found the student!
        // Return Blade view with student data
        return view('students.show', compact('student'));
    }

    /**
     * Show form to edit student
     * GET /students/{student}/edit
     * 
     * EVOLUTION:
     * Before: return '<form>...</form>'; (HTML string with hardcoded values)
     * Now: return view('students.edit', compact('student'));
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update student in database
     * PUT /students/{student}
     * 
     * EVOLUTION:
     * Before: return '<h1>Updated!</h1>...'; (HTML string)
     * Now: return redirect()->with('success', 'Message');
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'major' => 'required|string|max:255',
            'year' => 'required|integer|min:1|max:4'
        ]);

        // Update student in database
        $student->update($validated);
        
        // Redirect with flash message
        return redirect()->route('students.show', $student)
                        ->with('success', 'Student updated successfully!');
    }

    /**
     * Delete student from database
     * DELETE /students/{student}
     * 
     * EVOLUTION:
     * Before: return '<h1>Deleted!</h1>...'; (HTML string)
     * Now: return redirect()->with('success', 'Message');
     */
    public function destroy(Student $student)
    {
        $name = $student->name; // Store name before deletion
        $student->delete();
        
        // Redirect with flash message
        return redirect()->route('students.index')
                        ->with('success', "Student '{$name}' has been deleted successfully!");
    }

    /**
     * Simple example methods (now returning views)
     */
    public function hello()
    {
        $totalStudents = Student::count();
        return view('students.hello', compact('totalStudents'));
    }

    public function time()
    {
        $currentTime = now()->format('Y-m-d H:i:s');
        $totalStudents = Student::count();
        return view('students.time', compact('currentTime', 'totalStudents'));
    }
}
