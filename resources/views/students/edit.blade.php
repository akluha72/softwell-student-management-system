@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
    <div class="max-w-2xl">

        <div class="mb-6">
            <a href="{{ route('students.show', $student) }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">←
                Back to Student</a>
            <h2 class="text-xl font-semibold text-gray-900 mt-2">Edit Student</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $student->student_id }}</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="bg-gray-50 rounded-lg px-4 py-3 mb-5 flex items-center justify-between">
                <span class="text-sm text-gray-500">Student ID</span>
                <span class="font-mono text-sm font-medium text-gray-700">{{ $student->student_id }}</span>
            </div>
            <form action="{{ route('students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')

                @include('students._form')

                <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-gray-100">
                    <a href="{{ route('students.show', $student) }}"
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
