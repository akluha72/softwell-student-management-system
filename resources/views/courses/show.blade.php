@extends('layouts.app')

@section('title', $course->name)

@section('content')
    <div class="max-w-3xl">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-6">
            <div>
                <a href="{{ route('courses.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">← Back
                    to Courses</a>
                <h2 class="text-xl font-semibold text-gray-900 mt-2">{{ $course->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="font-mono text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $course->code }}</span>
                    <span class="text-sm text-gray-400">{{ $course->credit_hours }}
                        {{ $course->credit_hours === 1 ? 'credit' : 'credits' }}</span>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('courses.edit', $course) }}"
                    class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Edit
                </a>
                <form action="{{ route('courses.destroy', $course) }}" method="POST"
                    onsubmit="return confirm('Delete this course? This will also remove all related exam marks.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm border border-red-200 rounded-lg text-red-600 hover:bg-red-50 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Description --}}
        @if ($course->description)
            <div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
                <p class="text-sm text-gray-600 leading-relaxed">{{ $course->description }}</p>
            </div>
        @endif

        {{-- Stat cards --}}
        <div class="grid grid-cols-3 gap-4 mb-6 " style="grid-template-columns: repeat(3, minmax(0, 1fr))">
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 mb-1">Students enrolled</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $course->students->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 mb-1">Average mark</p>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ $course->average_mark ? number_format($course->average_mark, 1) : '—' }}
                </p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 mb-1">Class grade</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $course->average_grade ?? '—' }}</p>
            </div>
        </div>

        {{-- Enrolled students + their marks --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-medium text-gray-900">Student Marks</h3>
                <a href="{{ route('exam-marks.create', ['course_id' => $course->id]) }}"
                    class="text-xs text-indigo-600 hover:underline">+ Add mark</a>
            </div>

            @if ($course->examMarks->isEmpty())
                <div class="text-center py-10">
                    <p class="text-sm text-gray-400">No exam marks recorded yet.</p>
                </div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Student</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Mark</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Grade</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Exam Date</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($course->examMarks->sortByDesc('mark') as $mark)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3.5">
                                    <a href="{{ route('students.show', $mark->student) }}"
                                        class="font-medium text-gray-900 hover:text-indigo-600 transition">
                                        {{ $mark->student->name }}
                                    </a>
                                    <div class="text-xs text-gray-400 font-mono">{{ $mark->student->student_id }}</div>
                                </td>
                                <td class="px-5 py-3.5 font-medium text-gray-900">{{ number_format($mark->mark, 1) }}</td>
                                <td class="px-5 py-3.5">
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
                                <td class="px-5 py-3.5 text-gray-600">{{ $mark->exam_date->format('d M Y') }}</td>
                                <td class="px-5 py-3.5 text-gray-500">{{ $mark->remarks ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
@endsection
