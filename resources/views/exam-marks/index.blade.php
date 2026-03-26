@extends('layouts.app')

@section('title', 'Exam Marks')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Exam Marks</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $examMarks->total() }} records total</p>
        </div>
        <a href="{{ route('exam-marks.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Mark
        </a>
    </div>

    @if ($examMarks->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <p class="text-gray-500 text-sm">No exam marks recorded yet.</p>
            <a href="{{ route('exam-marks.create') }}" class="mt-3 inline-block text-sm text-indigo-600 hover:underline">Add
                the first mark</a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Student</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Course</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Mark</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Grade</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Exam Date</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($examMarks as $mark)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('students.show', $mark->student) }}"
                                    class="font-medium text-gray-900 hover:text-indigo-600 transition">
                                    {{ $mark->student->name }}
                                </a>
                                <div class="text-xs text-gray-400 font-mono">{{ $mark->student->student_id }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('courses.show', $mark->course) }}"
                                    class="text-gray-700 hover:text-indigo-600 transition">
                                    {{ $mark->course->name }}
                                </a>
                                <div class="text-xs text-gray-400 font-mono">{{ $mark->course->code }}</div>
                            </td>
                            <td class="px-5 py-3.5 font-medium text-gray-900">
                                {{ number_format($mark->mark, 1) }}
                            </td>
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
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('exam-marks.show', $mark) }}"
                                        class="text-xs text-gray-500 hover:text-indigo-600 transition">View</a>
                                    <a href="{{ route('exam-marks.edit', $mark) }}"
                                        class="text-xs text-gray-500 hover:text-indigo-600 transition">Edit</a>
                                    <form action="{{ route('exam-marks.destroy', $mark) }}" method="POST"
                                        onsubmit="return confirm('Delete this exam mark?')">
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

            @if ($examMarks->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $examMarks->links() }}
                </div>
            @endif
        </div>
    @endif
@endsection
