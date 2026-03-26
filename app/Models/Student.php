<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'student_id',
        'phone',
        'gender',
        'date_of_birth',
        'enrolled_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrolled_at' => 'date',
    ];

    // ── Relationships ────────────────────────────────────────

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->withPivot('enrolled_at', 'status')
            ->withTimestamps();
    }

    public function examMarks(): HasMany
    {
        return $this->hasMany(ExamMark::class);
    }

    // ── Accessors ────────────────────────────────────────────

    /**
     * Get the student's overall average mark across all exams.
     */
    public function getAverageMarkAttribute(): ?float
    {
        $avg = $this->examMarks()->avg('mark');
        return $avg ? round($avg, 2) : null;
    }

    /**
     * Derive a grade from the average mark.
     */
    public function getAverageGradeAttribute(): ?string
    {
        if (is_null($this->average_mark))
            return null;
        return ExamMark::gradeFromMark($this->average_mark);
    }
}