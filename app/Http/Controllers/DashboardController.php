<?php

namespace App\Http\Controllers;

use App\Models\ExamMark;
use App\Models\Course;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalMarks = ExamMark::count();
        $overallAvg = round(ExamMark::avg('mark') ?? 0, 1);

        $gradeDistribution = collect(['A+', 'A', 'B+', 'B', 'C+', 'C', 'D', 'F'])
            ->mapWithKeys(fn($grade) => [
                $grade => ExamMark::where('grade', $grade)->count()
            ]);

        $topStudents = Student::withAvg('examMarks', 'mark')
            ->withCount('examMarks')
            ->having('exam_marks_count', '>', 0)
            ->orderByDesc('exam_marks_avg_mark')
            ->limit(5)
            ->get();

        $recentMarks = ExamMark::with(['student', 'course'])
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalCourses',
            'totalMarks',
            'overallAvg',
            'gradeDistribution',
            'topStudents',
            'recentMarks'
        ));
    }
}