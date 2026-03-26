<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamMarkController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {

    $totalStudents = \App\Models\Student::count();
    $totalCourses  = \App\Models\Course::count();
    $totalMarks    = \App\Models\ExamMark::count();
    $overallAvg    = round(\App\Models\ExamMark::avg('mark') ?? 0, 1);

    // Grade distribution
    $gradeDistribution = collect(['A+','A','B+','B','C+','C','D','F'])
        ->mapWithKeys(fn ($grade) => [
            $grade => \App\Models\ExamMark::where('grade', $grade)->count()
        ]);

    // Top 5 students by average mark
    $topStudents = \App\Models\Student::withAvg('examMarks', 'mark')
        ->withCount('examMarks')
        ->having('exam_marks_count', '>', 0)
        ->orderByDesc('exam_marks_avg_mark')
        ->limit(5)
        ->get();

    // Recent 8 exam marks
    $recentMarks = \App\Models\ExamMark::with(['student', 'course'])
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

})->name('dashboard');

// Resource routes
Route::resource('students', StudentController::class);
Route::resource('courses', CourseController::class);
Route::resource('exam-marks', ExamMarkController::class);

// Reports
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('students', [ReportController::class, 'students'])->name('students');
    Route::get('courses', [ReportController::class, 'courses'])->name('courses');
    Route::get('students/export', [ReportController::class, 'exportStudents'])->name('students.export');
    Route::get('courses/export', [ReportController::class, 'exportCourses'])->name('courses.export');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
