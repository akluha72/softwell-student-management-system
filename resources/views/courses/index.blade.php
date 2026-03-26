@extends('layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Courses</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $courses->total() }} courses available</p>
        </div>
        <a href="{{ route('courses.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Course
        </a>
    </div>

    @if ($courses->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <p class="text-gray-500 text-sm">No courses yet.</p>
            <a href="{{ route('courses.create') }}" class="mt-3 inline-block text-sm text-indigo-600 hover:underline">Add
                the first course</a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Course</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Code</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Credits</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Students</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Avg Mark</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($courses as $course)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5">
                                <div class="font-medium text-gray-900">{{ $course->name }}</div>
                                @if ($course->description)
                                    <div class="text-gray-400 text-xs mt-0.5 line-clamp-1">{{ $course->description }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-mono text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                    {{ $course->code }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $course->credit_hours }} cr</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $course->students_count }}</td>
                            <td class="px-5 py-3.5">
                                @if ($course->exam_marks_avg_mark)
                                    <span class="inline-flex items-center gap-1.5">
                                        <span
                                            class="font-medium text-gray-900">{{ number_format($course->exam_marks_avg_mark, 1) }}</span>
                                        <span
                                            class="text-xs px-1.5 py-0.5 rounded font-medium
                                    {{ $course->exam_marks_avg_mark >= 80
                                        ? 'bg-green-100 text-green-700'
                                        : ($course->exam_marks_avg_mark >= 60
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-red-100 text-red-700') }}">
                                            {{ \App\Models\ExamMark::gradeFromMark($course->exam_marks_avg_mark) }}
                                        </span>
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('courses.show', $course) }}"
                                        class="text-xs text-gray-500 hover:text-indigo-600 transition">View</a>
                                    <a href="{{ route('courses.edit', $course) }}"
                                        class="text-xs text-gray-500 hover:text-indigo-600 transition">Edit</a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST"
                                        onsubmit="return confirm('Delete {{ $course->name }}? This will also remove all exam marks for this course.')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="text-xs text-gray-500 hover:text-red-600 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($courses->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    @endif
@endsection
