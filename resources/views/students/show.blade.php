@extends('layouts.app')

@section('title', $student->name)

@section('content')
    <div class="max-w-3xl">

        {{-- Header --}}
        <div class="flex items-start justify-between mb-6">
            <div>
                <a href="{{ route('students.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">← Back
                    to Students</a>
                <h2 class="text-xl font-semibold text-gray-900 mt-2">{{ $student->name }}</h2>
                <p class="text-sm text-gray-500 font-mono mt-0.5">{{ $student->student_id }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('students.edit', $student) }}"
                    class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Edit
                </a>
                <form action="{{ route('students.destroy', $student) }}" method="POST"
                    onsubmit="return confirm('Delete this student? This will also remove their exam marks.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm border border-red-200 rounded-lg text-red-600 hover:bg-red-50 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="grid gap-4 mb-6" style="grid-template-columns: repeat(3, minmax(0, 1fr))">
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 mb-1">Courses enrolled</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $student->courses->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 mb-1">Average mark</p>
                <p class="text-2xl font-semibold text-gray-900">
                    {{ $student->average_mark ? number_format($student->average_mark, 1) : '—' }}
                </p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-4">
                <p class="text-xs text-gray-500 mb-1">Overall grade</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $student->average_grade ?? '—' }}</p>
            </div>
        </div>

        {{-- Student details --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <h3 class="text-sm font-medium text-gray-900 mb-4">Personal Information</h3>
            <dl class="grid gap-x-6 gap-y-4 text-sm" style="grid-template-columns: repeat(2, minmax(0, 1fr))">
                <div>
                    <dt class="text-gray-500">Email</dt>
                    <dd class="text-gray-900 mt-0.5">{{ $student->email }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Phone</dt>
                    <dd class="text-gray-900 mt-0.5">{{ $student->phone ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Gender</dt>
                    <dd class="text-gray-900 mt-0.5 capitalize">{{ $student->gender ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Date of Birth</dt>
                    <dd class="text-gray-900 mt-0.5">
                        {{ $student->date_of_birth ? $student->date_of_birth->format('d M Y') : '—' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-500">Enrolled Date</dt>
                    <dd class="text-gray-900 mt-0.5">{{ $student->enrolled_at->format('d M Y') }}</dd>
                </div>
            </dl>
        </div>

        {{-- Exam marks table --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-medium text-gray-900">Exam Marks</h3>
                <a href="{{ route('exam-marks.create', ['student_id' => $student->id]) }}"
                    class="text-xs text-indigo-600 hover:underline">+ Add mark</a>
            </div>

            @if ($student->examMarks->isEmpty())
                <div class="text-center py-10">
                    <p class="text-sm text-gray-400">No exam marks recorded yet.</p>
                </div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Course</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Mark</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Grade</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Exam Date</th>
                            <th class="text-left px-5 py-3 font-medium text-gray-500">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($student->examMarks as $mark)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3.5">
                                    <div class="font-medium text-gray-900">{{ $mark->course->name }}</div>
                                    <div class="text-xs text-gray-400 font-mono">{{ $mark->course->code }}</div>
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
