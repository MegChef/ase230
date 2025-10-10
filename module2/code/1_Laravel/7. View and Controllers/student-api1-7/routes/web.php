<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes (Lesson 6: Views and Controllers)
|--------------------------------------------------------------------------
|
| Evolution from Lesson 5:
| ❌ BEFORE: Routes returned HTML strings from controllers
| ✅ NOW: Routes return Blade views with proper templating
|
| Key Teaching Points:
| 1. RESTful Resource Routes - Standard web patterns
| 2. Named Routes - Better maintainability 
| 3. Route Model Binding - Automatic record lookup
| 4. Web Middleware - Sessions, CSRF protection
| 5. View Integration - Controllers return views, not strings
|
*/

// Welcome/Homepage Route
Route::get('/', function () {
    return redirect()->route('students.index');
});

// IMPORTANT: Demo routes MUST be defined BEFORE resource routes
// to avoid conflicts with /students/{student} pattern
Route::get('/students/hello', [StudentController::class, 'hello'])->name('students.hello');
Route::get('/students/time', [StudentController::class, 'time'])->name('students.time');

// RESTful Student Resource Routes
// This creates all CRUD routes automatically:
// GET    /students           -> index   (show all students)
// GET    /students/create    -> create  (show create form) 
// POST   /students           -> store   (save new student)
// GET    /students/{student} -> show    (show specific student)
// GET    /students/{student}/edit -> edit (show edit form)
// PUT    /students/{student} -> update  (update student)
// DELETE /students/{student} -> destroy (delete student)
Route::resource('students', StudentController::class);

/*
|--------------------------------------------------------------------------
| Route Features Explanation
|--------------------------------------------------------------------------
|
| 1. Route::resource() creates all RESTful routes automatically
|    - Much cleaner than defining each route individually
|    - Follows Laravel conventions
|    - Automatic route names (students.index, students.show, etc.)
|
| 2. Route Model Binding (automatic):
|    - {student} parameter automatically loads Student model
|    - If student not found, automatic 404 response
|    - No need for manual Student::findOrFail() in controllers
|
| 3. Named Routes:
|    - route('students.index') in views instead of hardcoded URLs
|    - Easy to change URLs without updating all views
|    - Better maintainability
|
| 4. HTTP Verbs:
|    - GET: Display forms and data
|    - POST: Create new records  
|    - PUT: Update existing records
|    - DELETE: Remove records
|
| 5. Web Middleware (automatic):
|    - Session handling for flash messages
|    - CSRF protection for forms
|    - Cookie handling
|    - View sharing
|
| 6. Route Order Matters:
|    - More specific routes (/students/hello) before general ones (/students/{student})
|    - Laravel matches routes from top to bottom
|    - First match wins!
|
|--------------------------------------------------------------------------
| Evolution Summary
|--------------------------------------------------------------------------
|
| Lesson 4: Basic routes with static data
| Lesson 5: Routes + Models (database operations)
| Lesson 6: Routes + Models + Views (complete MVC)
|
| BEFORE (Lesson 5):
| Route::get('/students', function() {
|     return '<h1>Students</h1>' . Student::all();
| });
|
| NOW (Lesson 6):  
| Route::resource('students', StudentController::class);
| // Controller returns: view('students.index', compact('students'))
|
*/
