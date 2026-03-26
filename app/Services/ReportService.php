<?php

namespace App\Services;

use App\Models\Course;
use App\Models\ExamMark;
use App\Models\Student;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * Average mark per student across all their courses.
     * Returns a collection sorted by average mark descending.
     */
    public function studentAverages(): Collection
    {
        return Student::withAvg('examMarks', 'mark')
            ->withCount('examMarks')
            ->having('exam_marks_count', '>', 0)
            ->orderByDesc('exam_marks_avg_mark')
            ->get()
            ->map(function (Student $student) {
                $avg = round($student->exam_marks_avg_mark, 2);
                return (object) [
                    'id' => $student->id,
                    'name' => $student->name,
                    'student_id' => $student->student_id,
                    'email' => $student->email,
                    'total_exams' => $student->exam_marks_count,
                    'average_mark' => $avg,
                    'grade' => ExamMark::gradeFromMark($avg),
                ];
            });
    }

    /**
     * Average mark per course across all students.
     * Returns a collection sorted by average mark descending.
     */
    public function courseAverages(): Collection
    {
        return Course::withAvg('examMarks', 'mark')
            ->withCount('examMarks')
            ->withCount('students')
            ->having('exam_marks_count', '>', 0)
            ->orderByDesc('exam_marks_avg_mark')
            ->get()
            ->map(function (Course $course) {
                $avg = round($course->exam_marks_avg_mark, 2);
                $highest = $course->examMarks()->max('mark');
                $lowest = $course->examMarks()->min('mark');

                return (object) [
                    'id' => $course->id,
                    'name' => $course->name,
                    'code' => $course->code,
                    'credit_hours' => $course->credit_hours,
                    'total_students' => $course->students_count,
                    'total_exams' => $course->exam_marks_count,
                    'average_mark' => $avg,
                    'grade' => ExamMark::gradeFromMark($avg),
                    'highest_mark' => $highest ? round($highest, 2) : null,
                    'lowest_mark' => $lowest ? round($lowest, 2) : null,
                ];
            });
    }

    /**
     * Grade distribution across ALL exam marks.
     * Used for the summary stats on the report pages.
     */
    public function gradeDistribution(): array
    {
        $grades = ['A+', 'A', 'B+', 'B', 'C+', 'C', 'D', 'F'];
        $total = ExamMark::count();

        if ($total === 0)
            return [];

        return collect($grades)->mapWithKeys(function ($grade) use ($total) {
            $count = ExamMark::where('grade', $grade)->count();
            return [
                $grade => [
                    'count' => $count,
                    'percentage' => $total > 0 ? round(($count / $total) * 100, 1) : 0,
                ]
            ];
        })->toArray();
    }
}