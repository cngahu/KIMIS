<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // College relationship
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class, 'college_id');
    }

    // Academic Department
    public function academicDepartment(): BelongsTo
    {
        return $this->belongsTo(AcademicDepartment::class, 'academic_department_id');
    }

    // Department (Fix class name if typo)
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Course Requirements
    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class);
    }

    // Course Stage Mappings (Pivot table)
    public function stageMappings(): HasMany
    {
        return $this->hasMany(CourseStageMapping::class)
            ->orderBy('sequence_number');
    }

    /*
    |--------------------------------------------------------------------------
    | Course Stages (Timeline)
    |--------------------------------------------------------------------------
    |
    | Many-to-many via course_stage_mappings
    | sequence_number controls stage order
    |
    */

    public function stages(): BelongsToMany
    {
        return $this->belongsToMany(
                CourseStage::class,
                'course_stage_mappings',
                'course_id',
                'course_stage_id'
            )
            ->withPivot('sequence_number')
            ->orderBy('course_stage_mappings.sequence_number');
    }

    /*
    |--------------------------------------------------------------------------
    | Enrollments & Students
    |--------------------------------------------------------------------------
    */

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            Enrollment::class,
            'course_id',     // Foreign key on enrollments table
            'id',            // Foreign key on students table
            'id',            // Local key on courses table
            'student_id'     // Local key on enrollments table
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Administrative Relationships
    |--------------------------------------------------------------------------
    */

    public function hods(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withTimestamps();
    }

    public function masterdata(): HasMany
    {
        return $this->hasMany(Masterdata::class, 'course_id');
    }

    public function courseCohorts(): HasMany
    {
        return $this->hasMany(CourseCohort::class, 'course_id');
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class, 'course_id');
    }
}