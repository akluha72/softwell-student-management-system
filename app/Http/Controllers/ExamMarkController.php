<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreExamMarkRequest;
use App\Http\Requests\UpdateExamMarkRequest;
use App\Models\Course;
use App\Models\ExamMark;
use App\Models\Student;

class ExamMarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examMarks = ExamMark::with(['student', 'course'])->latest()->paginate(15);
        return view('exam-marks.index', compact('examMarks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();

        // Pre-select student/course if passed via query string
        // e.g. from students.show "Add mark" link
        $selectedStudentId = request('student_id');
        $selectedCourseId = request('course_id');

        return view('exam-marks.create', compact(
            'students',
            'courses',
            'selectedStudentId',
            'selectedCourseId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExamMarkRequest $request)
    {
        ExamMark::create($request->validated());

        $student = Student::find($request->student_id);
        $student->courses()->syncWithoutDetaching([
            $request->course_id =>
                [
                    'enrolled_at' => now(),
                    'status' => 'active'
                ],

        ]);

        if ($request->has('redirect_to_student')) {
            return redirect()->route('students.show', $request->student_id)
                ->with('success', 'Exam mark added successfully.');
        }

        return redirect()->route('exam-marks.index')
            ->with('success', 'Exam mark added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamMark $examMark)
    {
        $examMark->load(['student', 'course']);
        return view('exam-marks.show', compact('examMark'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamMark $examMark)
    {
        $students = Student::orderBy('name')->get();
        $courses = Course::orderBy('name')->get();

        return view('exam-marks.edit', compact('examMark', 'students', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExamMarkRequest $request, ExamMark $examMark)
    {
        $examMark->update($request->validated());

        // Ensure enrollment exists for the (possibly updated) course
        $student = Student::find($request->student_id);
        $student->courses()->syncWithoutDetaching([
            $request->course_id => [
                'enrolled_at' => now()->toDateString(),
                'status' => 'active',
            ]
        ]);

        return redirect()->route('exam-marks.show', $examMark)
            ->with('success', 'Exam mark updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamMark $examMark)
    {
        $studentId = $examMark->student_id;
        $examMark->delete();

        return redirect()->route('exam-marks.index')
            ->with('success', 'Exam mark deleted successfully.');
    }
}
