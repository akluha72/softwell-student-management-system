<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamMark extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'mark',
        'grade',
        'exam_date',
        'remarks',
    ];

    protected $casts = [
        'mark' => 'float',
        'exam_date' => 'date',
    ];

    // ── Boot — auto-calculate grade on save ──────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (ExamMark $examMark) {
            $examMark->grade = self::gradeFromMark($examMark->mark);
        });
    }

    // ── Grade logic (single source of truth) ─────────────────

    public static function gradeFromMark(float $mark): string
    {
        return match (true) {
            $mark >= 90 => 'A+',
            $mark >= 80 => 'A',
            $mark >= 75 => 'B+',
            $mark >= 70 => 'B',
            $mark >= 65 => 'C+',
            $mark >= 60 => 'C',
            $mark >= 55 => 'D',
            default => 'F',
        };
    }

    // ── Relationships ─────────────────────────────────────────

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}