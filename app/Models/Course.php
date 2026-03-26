<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'credit_hours',
        'description',
    ];

    protected $casts = [
        'credit_hours' => 'integer',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->withPivot('enrolled_at', 'status')
            ->withTimestamps();
    }

    public function examMarks(): HasMany
    {
        return $this->hasMany(ExamMark::class);
    }

    /**
     * Get the course's average mark across all students.
     */
    public function getAverageMarkAttribute(): ?float
    {
        $avg = $this->examMarks()->avg('mark');
        return $avg ? round($avg, 2) : null;
    }

    public function getAverageGradeAttribute(): ?string
    {
        if (is_null($this->average_mark)) return null;
        return ExamMark::gradeFromMark($this->average_mark);
    }
}