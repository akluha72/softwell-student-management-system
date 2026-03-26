@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- Page heading --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Dashboard</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ now()->format('l, d F Y') }}</p>
    </div>

    {{-- ── Stat cards ─────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <a href="{{ route('students.index') }}"
            class="bg-white rounded-xl border border-gray-200 p-5 hover:border-indigo-300 hover:shadow-sm transition group">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Students</p>
                <div
                    class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-100 transition">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-semibold text-gray-900">{{ $totalStudents }}</p>
            <p class="text-xs text-gray-400 mt-1">enrolled</p>
        </a>

        <a href="{{ route('courses.index') }}"
            class="bg-white rounded-xl border border-gray-200 p-5 hover:border-indigo-300 hover:shadow-sm transition group">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Courses</p>
                <div
                    class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center group-hover:bg-purple-100 transition">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-semibold text-gray-900">{{ $totalCourses }}</p>
            <p class="text-xs text-gray-400 mt-1">active</p>
        </a>

        <a href="{{ route('exam-marks.index') }}"
            class="bg-white rounded-xl border border-gray-200 p-5 hover:border-indigo-300 hover:shadow-sm transition group">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Exam Marks</p>
                <div
                    class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center group-hover:bg-amber-100 transition">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-semibold text-gray-900">{{ $totalMarks }}</p>
            <p class="text-xs text-gray-400 mt-1">recorded</p>
        </a>

        <a href="{{ route('reports.students') }}"
            class="bg-white rounded-xl border border-gray-200 p-5 hover:border-indigo-300 hover:shadow-sm transition group">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Overall Avg</p>
                <div
                    class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100 transition">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-semibold text-gray-900">
                {{ $totalMarks > 0 ? $overallAvg : '—' }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                @if ($totalMarks > 0)
                    {{ \App\Models\ExamMark::gradeFromMark($overallAvg) }} overall grade
                @else
                    no data yet
                @endif
            </p>
        </a>

    </div>

    {{-- ── Main grid ───────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Grade distribution --}}
        <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-900">Grade distribution</h3>
                <a href="{{ route('reports.students') }}" class="text-xs text-indigo-600 hover:underline">View report</a>
            </div>

            @if ($totalMarks === 0)
                <p class="text-sm text-gray-400 text-center py-6">No data yet.</p>
            @else
                <div class="space-y-2">
                    @php
                        $gradeColors = [
                            'A+' => ['bar' => 'bg-green-500', 'badge' => 'bg-green-100 text-green-700'],
                            'A' => ['bar' => 'bg-green-400', 'badge' => 'bg-green-100 text-green-700'],
                            'B+' => ['bar' => 'bg-teal-400', 'badge' => 'bg-teal-100 text-teal-700'],
                            'B' => ['bar' => 'bg-yellow-400', 'badge' => 'bg-yellow-100 text-yellow-700'],
                            'C+' => ['bar' => 'bg-yellow-400', 'badge' => 'bg-yellow-100 text-yellow-700'],
                            'C' => ['bar' => 'bg-orange-400', 'badge' => 'bg-orange-100 text-orange-700'],
                            'D' => ['bar' => 'bg-red-400', 'badge' => 'bg-red-100 text-red-700'],
                            'F' => ['bar' => 'bg-red-600', 'badge' => 'bg-red-100 text-red-700'],
                        ];
                    @endphp

                    @foreach ($gradeDistribution as $grade => $count)
                        @if ($count > 0)
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-medium w-6 text-right text-gray-600">{{ $grade }}</span>
                                <div class="flex-1 bg-gray-100 rounded-full h-2">
                                    <div class="{{ $gradeColors[$grade]['bar'] }} h-2 rounded-full transition-all"
                                        style="width: {{ round(($count / $totalMarks) * 100) }}%">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 w-6 text-right">{{ $count }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Top students --}}
        <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-900">Top students</h3>
                <a href="{{ route('reports.students') }}" class="text-xs text-indigo-600 hover:underline">See all</a>
            </div>

            @if ($topStudents->isEmpty())
                <p class="text-sm text-gray-400 text-center py-6">No data yet.</p>
            @else
                <div class="space-y-3">
                    @foreach ($topStudents as $i => $student)
                        <div class="flex items-center gap-3">
                            {{-- Rank badge --}}
                            <span
                                class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-medium shrink-0
                        {{ $i === 0
                            ? 'bg-amber-100 text-amber-700'
                            : ($i === 1
                                ? 'bg-gray-100 text-gray-600'
                                : ($i === 2
                                    ? 'bg-orange-100 text-orange-600'
                                    : 'bg-gray-50 text-gray-400')) }}">
                                {{ $i + 1 }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('students.show', $student) }}"
                                    class="text-sm font-medium text-gray-900 hover:text-indigo-600 transition truncate block">
                                    {{ $student->name }}
                                </a>
                                <p class="text-xs text-gray-400 font-mono">{{ $student->student_id }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ number_format($student->exam_marks_avg_mark, 1) }}
                                </span>
                                <span
                                    class="ml-1 text-xs px-1.5 py-0.5 rounded font-medium
                            {{ $student->exam_marks_avg_mark >= 80
                                ? 'bg-green-100 text-green-700'
                                : ($student->exam_marks_avg_mark >= 60
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">
                                    {{ \App\Models\ExamMark::gradeFromMark($student->exam_marks_avg_mark) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Quick actions --}}
        <div class="lg:col-span-1 bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="text-sm font-medium text-gray-900 mb-4">Quick actions</h3>
            <div class="space-y-2">
                <a href="{{ route('students.create') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition group">
                    <div
                        class="w-7 h-7 bg-indigo-100 rounded-md flex items-center justify-center group-hover:bg-indigo-200 transition">
                        <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Add new student</span>
                </a>
                <a href="{{ route('courses.create') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-gray-200 hover:border-purple-300 hover:bg-purple-50 transition group">
                    <div
                        class="w-7 h-7 bg-purple-100 rounded-md flex items-center justify-center group-hover:bg-purple-200 transition">
                        <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Add new course</span>
                </a>
                <a href="{{ route('exam-marks.create') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-gray-200 hover:border-amber-300 hover:bg-amber-50 transition group">
                    <div
                        class="w-7 h-7 bg-amber-100 rounded-md flex items-center justify-center group-hover:bg-amber-200 transition">
                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Record exam mark</span>
                </a>
                <a href="{{ route('reports.students') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-gray-200 hover:border-green-300 hover:bg-green-50 transition group">
                    <div
                        class="w-7 h-7 bg-green-100 rounded-md flex items-center justify-center group-hover:bg-green-200 transition">
                        <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-700">Export reports</span>
                </a>
            </div>
        </div>

    </div>

    {{-- ── Recent exam marks ───────────────────────────────────── --}}
    <div class="mt-6 bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-medium text-gray-900">Recent exam marks</h3>
            <a href="{{ route('exam-marks.index') }}" class="text-xs text-indigo-600 hover:underline">View all</a>
        </div>

        @if ($recentMarks->isEmpty())
            <div class="text-center py-10">
                <p class="text-sm text-gray-400">No exam marks recorded yet.</p>
                <a href="{{ route('exam-marks.create') }}"
                    class="mt-2 inline-block text-sm text-indigo-600 hover:underline">
                    Record the first mark
                </a>
            </div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Student</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Course</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Mark</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Grade</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($recentMarks as $mark)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3">
                                <a href="{{ route('students.show', $mark->student) }}"
                                    class="font-medium text-gray-900 hover:text-indigo-600 transition">
                                    {{ $mark->student->name }}
                                </a>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $mark->course->name }}</td>
                            <td class="px-5 py-3 font-medium text-gray-900">{{ number_format($mark->mark, 1) }}</td>
                            <td class="px-5 py-3">
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-xs font-medium
                            {{ $mark->mark >= 80
                                ? 'bg-green-100 text-green-700'
                                : ($mark->mark >= 60
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">
                                    {{ $mark->grade }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-500">{{ $mark->exam_date->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
