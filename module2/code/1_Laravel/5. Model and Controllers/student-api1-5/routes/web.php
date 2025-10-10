<?php
/*
|--------------------------------------------------------------------------
| Web Routes (Lesson 5: Models and Controllers)
|--------------------------------------------------------------------------
| 
| Evolution from Lesson 4:
| ❌ BEFORE: Routes used {id} parameters with manual lookups
| ✅ NOW: Routes use {student} with automatic Route Model Binding
|
| Key Teaching Points:
| 1. Route Model Binding - Laravel automatically finds models
| 2. RESTful resource routes - standard CRUD operations
| 3. Named routes - easier route references
| 4. Automatic 404 handling - Laravel handles missing records
|
*/

use App\Http\Controllers\StudentController;

// Welcome page with links to test all functionality
Route::get('/', function () {
    return '<h1>Laravel Models and Controllers Demo (Lesson 5)</h1>
            <h2>🎯 Key Evolution: From Mockup Data → Real Database</h2>
            
            <h3>📚 Student Management (Web Interface)</h3>
            <ul>
                <li><a href="/students">📋 View All Students</a></li>
                <li><a href="/students/create">➕ Add New Student</a></li>
            </ul>
            
            <h3>🔌 API Endpoints (JSON Responses)</h3>
            <ul>
                <li><a href="/api/students">📋 All Students (JSON)</a></li>
                <li><a href="/api/students/stats">📊 Database Statistics</a></li>
                <li><a href="/api/students/search?name=John">🔍 Search Students</a></li>
            </ul>
            
            <h3>🧪 Test Examples (Simple Endpoints)</h3>
            <ul>
                <li><a href="/hello">👋 Hello World (with DB count)</a></li>
                <li><a href="/time">⏰ Current Time (with DB info)</a></li>
                <li><a href="/greet">💬 Greet Form</a></li>
            </ul>
            
            <hr>
            <p><strong>🆕 New in Lesson 5:</strong></p>
            <ul>
                <li>✅ Real database operations (no more static arrays)</li>
                <li>✅ Route Model Binding (automatic record lookup)</li>
                <li>✅ Built-in validation (data integrity)</li>
                <li>✅ Automatic timestamps (created_at, updated_at)</li>
                <li>✅ Advanced queries (search, filter, stats)</li>
            </ul>';
});

/*
|--------------------------------------------------------------------------
| Student Routes with Route Model Binding
|--------------------------------------------------------------------------
|
| EVOLUTION COMPARISON:
| 
| Lesson 4 (Old Way):
| Route::get('/student/{id}', [StudentController::class, 'show']);
| - Controller had to manually find student by ID
| - Manual 404 handling required
| 
| Lesson 5 (New Way):
| Route::get('/students/{student}', [StudentController::class, 'show']);
| - Laravel automatically finds Student model by ID
| - Automatic 404 if student doesn't exist
|
*/

// RESTful Student Resource Routes
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

// Alternative: Use resource() for automatic RESTful routes
// Route::resource('students', StudentController::class);

/*
|--------------------------------------------------------------------------
| Example Routes (Enhanced with Database Info)
|--------------------------------------------------------------------------
*/

// Simple example routes enhanced with database information
Route::get('/hello', [StudentController::class, 'hello']);
Route::get('/time', [StudentController::class, 'time']);

// Greet routes
Route::get('/greet', function() {
    $totalStudents = \App\Models\Student::count();
    return '<h1>Greet Someone</h1>
            <p>Current students in database: ' . $totalStudents . '</p>
            <form method="POST" action="/greet">
                <p>Name: <input type="text" name="name" placeholder="Enter your name"></p>
                <p><button type="submit">Say Hello</button></p>
            </form>
            <a href="/">Back to Home</a> | <a href="/students">View Students</a>';
});

Route::post('/greet', function(\Illuminate\Http\Request $request) {
    $name = $request->name ?? 'Anonymous';
    $totalStudents = \App\Models\Student::count();
    
    return '<h1>Hello, ' . $name . '!</h1>
            <p>Nice to meet you!</p>
            <p>FYI: We currently have ' . $totalStudents . ' students in our database.</p>
            <form method="POST" action="/greet">
                <p>Name: <input type="text" name="name" placeholder="Enter your name"></p>
                <p><button type="submit">Greet Again</button></p>
            </form>
            <a href="/">Back to Home</a> | <a href="/students">View Students</a>';
});

/*
|--------------------------------------------------------------------------
| Teaching Examples: Route Model Binding Demonstration
|--------------------------------------------------------------------------
*/

// Example: Custom route parameter binding (advanced topic)
// Route::get('/students/name/{student:name}', function(\App\Models\Student $student) {
//     return "Found student: " . $student->name;
// });

// Example: Route with constraints
Route::get('/students/year/{year}', function($year) {
    if (!in_array($year, [1, 2, 3, 4])) {
        abort(404, 'Invalid year. Must be 1-4.');
    }
    
    $students = \App\Models\Student::where('year', $year)->get();
    
    $html = "<h1>Year {$year} Students</h1>";
    foreach ($students as $student) {
        $html .= "<p>{$student->name} - {$student->major}</p>";
    }
    $html .= '<a href="/students">Back to All Students</a>';
    
    return $html;
})->where('year', '[1-4]'); // Route constraint: only accept 1-4
