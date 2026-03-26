@extends('layouts.app')

@section('title', 'Exam Mark')

@section('content')
    <div class="max-w-xl">

        <div class="flex items-start justify-between mb-6">
            <div>
                <a href="{{ route('exam-marks.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">←
                    Back to Exam Marks</a>
                <h2 class="text-xl font-semibold text-gray-900 mt-2">Exam Mark</h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('exam-marks.edit', $examMark) }}"
                    class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Edit
                </a>
                <form action="{{ route('exam-marks.destroy', $examMark) }}" method="POST"
                    onsubmit="return confirm('Delete this exam mark?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm border border-red-200 rounded-lg text-red-600 hover:bg-red-50 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Grade highlight card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">Mark</p>
                <p class="text-4xl font-semibold text-gray-900">{{ number_format($examMark->mark, 1) }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500 mb-1">Grade</p>
                <span
                    class="text-3xl font-semibold px-4 py-1.5 rounded-lg
                {{ $examMark->mark >= 80
                    ? 'bg-green-100 text-green-700'
                    : ($examMark->mark >= 60
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-red-100 text-red-700') }}">
                    {{ $examMark->grade }}
                </span>
            </div>
        </div>

        {{-- Details card --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-medium text-gray-900 mb-4">Details</h3>
            <dl class="space-y-4 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Student</dt>
                    <dd>
                        <a href="{{ route('students.show', $examMark->student) }}"
                            class="font-medium text-gray-900 hover:text-indigo-600 transition">
                            {{ $examMark->student->name }}
                        </a>
                        <span class="text-gray-400 font-mono text-xs ml-1">({{ $examMark->student->student_id }})</span>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Course</dt>
                    <dd>
                        <a href="{{ route('courses.show', $examMark->course) }}"
                            class="font-medium text-gray-900 hover:text-indigo-600 transition">
                            {{ $examMark->course->name }}
                        </a>
                        <span class="text-gray-400 font-mono text-xs ml-1">({{ $examMark->course->code }})</span>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Exam Date</dt>
                    <dd class="text-gray-900">{{ $examMark->exam_date->format('d M Y') }}</dd>
                </div>
                @if ($examMark->remarks)
                    <div class="pt-3 border-t border-gray-100">
                        <dt class="text-gray-500 mb-1">Remarks</dt>
                        <dd class="text-gray-700 leading-relaxed">{{ $examMark->remarks }}</dd>
                    </div>
                @endif
            </dl>
        </div>

    </div>
@endsection
