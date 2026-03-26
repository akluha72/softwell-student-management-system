@extends('layouts.app')

@section('title', 'Edit Exam Mark')

@section('content')
    <div class="max-w-2xl">

        <div class="mb-6">
            <a href="{{ route('exam-marks.show', $examMark) }}"
                class="text-sm text-gray-500 hover:text-indigo-600 transition">← Back</a>
            <h2 class="text-xl font-semibold text-gray-900 mt-2">Edit Exam Mark</h2>
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $examMark->student->name }} — {{ $examMark->course->name }}
            </p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('exam-marks.update', $examMark) }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $selectedStudentId = null;
                    $selectedCourseId = null;
                @endphp
                @include('exam-marks._form')

                <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-gray-100">
                    <a href="{{ route('exam-marks.show', $examMark) }}"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
