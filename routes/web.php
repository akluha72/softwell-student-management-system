<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamMarkController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

Route::get('students/{student}/report-card', [StudentController::class, 'reportCard'])
    ->name('students.report-card');

require __DIR__ . '/auth.php';
