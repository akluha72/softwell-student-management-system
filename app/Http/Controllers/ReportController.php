<?php

namespace App\Http\Controllers;

use App\Services\ReportService;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService)
    {
    }

    public function students()
    {
        $rows = $this->reportService->studentAverages();
        $gradeDistribution = $this->reportService->gradeDistribution();

        return view('reports.students', compact('rows', 'gradeDistribution'));
    }

    public function courses()
    {
        $rows = $this->reportService->courseAverages();
        $gradeDistribution = $this->reportService->gradeDistribution();

        return view('reports.courses', compact('rows', 'gradeDistribution'));
    }

    public function exportStudents()
    {
        $rows = $this->reportService->studentAverages();
        $filename = 'student-averages-' . now()->format('Y-m-d') . '.csv';

        return response()->stream(function () use ($rows) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility (important for Malay names)
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No.',
                'Student Name',
                'Student ID',
                'Email',
                'Total Exams',
                'Average Mark',
                'Grade',
            ]);

            foreach ($rows as $index => $row) {
                fputcsv($handle, [
                    $index + 1,
                    $row->name,
                    $row->student_id,
                    $row->email,
                    $row->total_exams,
                    number_format($row->average_mark, 2),
                    $row->grade,
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }

    public function exportCourses()
    {
        $rows = $this->reportService->courseAverages();
        $filename = 'course-averages-' . now()->format('Y-m-d') . '.csv';

        return response()->stream(function () use ($rows) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No.',
                'Course Name',
                'Course Code',
                'Credit Hours',
                'Total Students',
                'Total Exams',
                'Average Mark',
                'Grade',
                'Highest Mark',
                'Lowest Mark',
            ]);

            foreach ($rows as $index => $row) {
                fputcsv($handle, [
                    $index + 1,
                    $row->name,
                    $row->code,
                    $row->credit_hours,
                    $row->total_students,
                    $row->total_exams,
                    number_format($row->average_mark, 2),
                    $row->grade,
                    $row->highest_mark ? number_format($row->highest_mark, 2) : '-',
                    $row->lowest_mark ? number_format($row->lowest_mark, 2) : '-',
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ]);
    }
}