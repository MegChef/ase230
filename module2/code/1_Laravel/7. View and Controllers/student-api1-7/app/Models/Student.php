<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Student Model - Eloquent ORM (Same as Lesson 5)
 * 
 * This model handles all database operations for students table.
 * Uses Laravel's Eloquent ORM for clean, readable database interactions.
 */
class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 
     * This defines which fields can be filled using create() or fill() methods.
     * Important for security - prevents mass assignment vulnerabilities.
     */
    protected $fillable = [
        'name',
        'email', 
        'major',
        'year'
    ];

    /**
     * The attributes that should be cast to native types.
     * 
     * Laravel will automatically convert these database values 
     * to the specified PHP types when accessing them.
     */
    protected $casts = [
        'year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Example of accessor - if needed for views
    public function getYearNameAttribute()
    {
        $yearNames = [
            1 => 'Freshman',
            2 => 'Sophomore', 
            3 => 'Junior',
            4 => 'Senior'
        ];
        
        return $yearNames[$this->year] ?? 'Unknown';
    }

    // Example of scope - for filtering in views
    public function scopeByMajor($query, $major)
    {
        return $query->where('major', $major);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }
}
