<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Student Model - Represents the 'students' database table
 * 
 * Key Learning Points:
 * 1. Model = Database Table Representation
 * 2. $fillable = Mass Assignment Protection 
 * 3. $casts = Data Type Conversion
 * 4. Eloquent ORM provides powerful query methods
 */
class Student extends Model
{
    protected $fillable = [
        'name',
        'email', 
        'major',
        'year'
    ];

    protected $casts = [
        'year' => 'integer',
    ];
}
