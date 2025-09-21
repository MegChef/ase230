<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (For Reference - Not Main Focus of Lesson 6)
|--------------------------------------------------------------------------
|
| These API routes are included for reference, but Lesson 6 focuses on
| web routes that return views, not API routes that return JSON.
|
| The main learning objective is web controllers with Blade views.
|
*/

// Basic test routes
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'lesson' => 'Views and Controllers',
        'timestamp' => now()
    ]);
});

Route::get('/hello', function () {
    return response()->json([
        'message' => 'Hello from API!',
        'students_count' => \App\Models\Student::count()
    ]);
});

Route::get('/hello/{name}', function ($name) {
    return response()->json([
        'message' => "Hello {$name}!",
        'students_count' => \App\Models\Student::count()
    ]);
});

/*
|--------------------------------------------------------------------------
| Note: API vs Web Controllers
|--------------------------------------------------------------------------
|
| This lesson focuses on WEB controllers that return VIEWS:
| - Controllers return view() responses
| - Forms submit to web routes
| - Flash messages and redirects
| - Session-based user interaction
|
| API controllers would return JSON:
| - Controllers return response()->json()
| - Data exchange in JSON format
| - Stateless interactions
| - Token-based authentication
|
| For a complete API implementation, see the previous lesson's
| Api/StudentController.php file.
|
*/
