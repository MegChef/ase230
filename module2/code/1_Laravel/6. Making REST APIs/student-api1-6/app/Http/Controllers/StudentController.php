<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

/**
 * Student Web Controller - Using Laravel Models (Lesson 5)
 * 
 * Evolution from Lesson 4:
 * ❌ BEFORE: Used static arrays (mockup data)
 * ✅ NOW: Uses Laravel Model (real database operations)
 * 
 * Key Teaching Points:
 * 1. Route Model Binding - automatic record lookup
 * 2. Eloquent ORM - powerful database operations  
 * 3. Built-in validation - data integrity
 * 4. Automatic error handling - 404, validation errors
 */
class StudentController extends Controller
{
    /**
     * Display all students
     * GET /students
     * 
     * EVOLUTION:
     * Before: return $this->getMockStudents();
     * Now: return Student::all();
     */
    public function index()
    {
        // Query database to get all students
        $students = Student::all();
        
        // Simple HTML response showing all students
        $html = '<h1>All Students</h1>';
        $html .= '<a href="/students/create">Add New Student</a>';
        $html .= '<hr>';
        
        if ($students->count() > 0) {
            foreach ($students as $student) {
                $html .= '<div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">';
                $html .= '<h3>' . $student->name . '</h3>';
                $html .= '<p>Email: ' . $student->email . '</p>';
                $html .= '<p>Major: ' . $student->major . '</p>';
                $html .= '<p>Year: ' . $student->year . '</p>';
                $html .= '<a href="/students/' . $student->id . '">View Details</a> | ';
                $html .= '<a href="/students/' . $student->id . '/edit">Edit</a>';
                $html .= '</div>';
            }
        } else {
            $html .= '<p>No students found. <a href="/students/create">Add the first student</a></p>';
        }
        
        return $html;
    }

    /**
     * Show form to create new student
     * GET /students/create
     */
    public function create()
    {
        return '<h1>Add New Student</h1>
                <form method="POST" action="/students">
                    <p>Name: <input type="text" name="name" required></p>
                    <p>Email: <input type="email" name="email" required></p>
                    <p>Major: <input type="text" name="major" required></p>
                    <p>Year: 
                        <select name="year" required>
                            <option value="">Select Year</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </p>
                    <p><button type="submit">Create Student</button></p>
                </form>
                <a href="/students">Cancel</a>';
    }

    /**
     * Store new student in database
     * POST /students
     * 
     * EVOLUTION:
     * Before: Manual array manipulation
     * Now: Model::create() with validation
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
        $student = Student::create($validated);
        
        return '<h1>Success!</h1>
                <p>Student created successfully!</p>
                <p>ID: ' . $student->id . '</p>
                <p>Name: ' . $student->name . '</p>
                <p>Email: ' . $student->email . '</p>
                <p>Major: ' . $student->major . '</p>
                <p>Year: ' . $student->year . '</p>
                <a href="/students">View All Students</a> | 
                <a href="/students/create">Add Another</a>';
    }

    /**
     * Display specific student
     * GET /students/{student}
     * 
     * EVOLUTION - Route Model Binding:
     * Before: Manual ID lookup + 404 handling
     * Now: Laravel automatically finds student or returns 404
     */
    public function show(Student $student)
    {
        // Laravel automatically found the student!
        // If student doesn't exist, Laravel automatically returns 404
        
        return '<h1>Student Details</h1>
                <p><strong>ID:</strong> ' . $student->id . '</p>
                <p><strong>Name:</strong> ' . $student->name . '</p>
                <p><strong>Email:</strong> ' . $student->email . '</p>
                <p><strong>Major:</strong> ' . $student->major . '</p>
                <p><strong>Year:</strong> ' . $student->year . '</p>
                <p><strong>Created:</strong> ' . $student->created_at . '</p>
                <p><strong>Updated:</strong> ' . $student->updated_at . '</p>
                <hr>
                <a href="/students">Back to All Students</a> | 
                <a href="/students/' . $student->id . '/edit">Edit Student</a> |
                <form method="POST" action="/students/' . $student->id . '" style="display: inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" onclick="return confirm(\'Are you sure?\')">Delete</button>
                </form>';
    }

    /**
     * Show form to edit student
     * GET /students/{student}/edit
     */
    public function edit(Student $student)
    {
        return '<h1>Edit Student: ' . $student->name . '</h1>
                <form method="POST" action="/students/' . $student->id . '">
                    <input type="hidden" name="_method" value="PUT">
                    <p>Name: <input type="text" name="name" value="' . $student->name . '" required></p>
                    <p>Email: <input type="email" name="email" value="' . $student->email . '" required></p>
                    <p>Major: <input type="text" name="major" value="' . $student->major . '" required></p>
                    <p>Year: 
                        <select name="year" required>
                            <option value="1"' . ($student->year == 1 ? ' selected' : '') . '>1st Year</option>
                            <option value="2"' . ($student->year == 2 ? ' selected' : '') . '>2nd Year</option>
                            <option value="3"' . ($student->year == 3 ? ' selected' : '') . '>3rd Year</option>
                            <option value="4"' . ($student->year == 4 ? ' selected' : '') . '>4th Year</option>
                        </select>
                    </p>
                    <p><button type="submit">Update Student</button></p>
                </form>
                <a href="/students/' . $student->id . '">Cancel</a>';
    }

    /**
     * Update student in database
     * PUT /students/{student}
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
        
        return '<h1>Updated!</h1>
                <p>Student information updated successfully!</p>
                <p>Name: ' . $student->name . '</p>
                <p>Email: ' . $student->email . '</p>
                <p>Major: ' . $student->major . '</p>
                <p>Year: ' . $student->year . '</p>
                <a href="/students/' . $student->id . '">View Student</a> |
                <a href="/students">All Students</a>';
    }

    /**
     * Delete student from database
     * DELETE /students/{student}
     */
    public function destroy(Student $student)
    {
        $name = $student->name; // Store name before deletion
        $student->delete();
        
        return '<h1>Deleted!</h1>
                <p>Student "' . $name . '" has been removed from the database</p>
                <a href="/students">View All Students</a> | 
                <a href="/students/create">Add New Student</a>';
    }

    /**
     * Simple example methods (keeping from Lesson 4 for comparison)
     */
    public function hello()
    {
        return '<h1>Hello World!</h1>
                <p>This is a simple Laravel controller response</p>
                <p>Total students in database: ' . Student::count() . '</p>
                <a href="/students">View Students</a>';
    }

    public function time()
    {
        return '<h1>Current Time</h1>
                <p>' . date('Y-m-d H:i:s') . '</p>
                <p>Students in database: ' . Student::count() . '</p>
                <a href="/students">View Students</a>';
    }
}
