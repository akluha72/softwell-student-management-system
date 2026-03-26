@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Students</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $students->total() }} students enrolled</p>
        </div>
        <a href="{{ route('students.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Student
        </a>
    </div>

    @if ($students->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <p class="text-gray-500 text-sm">No students yet.</p>
            <a href="{{ route('students.create') }}" class="mt-3 inline-block text-sm text-indigo-600 hover:underline">Add
                the first student</a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Student</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Student ID</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Enrolled</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Exams</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Avg Mark</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($students as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5">
                                <div class="font-medium text-gray-900">{{ $student->name }}</div>
                                <div class="text-gray-400 text-xs">{{ $student->email }}</div>
                            </td>
                            <td class="px-5 py-3.5 text-gray-600 font-mono text-xs">{{ $student->student_id }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $student->enrolled_at->format('d M Y') }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $student->exam_marks_count }}</td>
                            <td class="px-5 py-3.5">
                                @if ($student->exam_marks_avg_mark)
                                    <span class="inline-flex items-center gap-1.5">
                                        <span
                                            class="font-medium text-gray-900">{{ number_format($student->exam_marks_avg_mark, 1) }}</span>
                                        <span
                                            class="text-xs px-1.5 py-0.5 rounded font-medium
                                    {{ $student->exam_marks_avg_mark >= 80
                                        ? 'bg-green-100 text-green-700'
                                        : ($student->exam_marks_avg_mark >= 60
                                            ? 'bg-yellow-100 text-yellow-700'
                                            : 'bg-red-100 text-red-700') }}">
                                            {{ \App\Models\ExamMark::gradeFromMark($student->exam_marks_avg_mark) }}
                                        </span>
                                    </span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('students.show', $student) }}"
                                        class="text-xs text-gray-500 hover:text-indigo-600 transition">View</a>
                                    <a href="{{ route('students.edit', $student) }}"
                                        class="text-xs text-gray-500 hover:text-indigo-600 transition">Edit</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST"
                                        onsubmit="return confirm('Delete {{ $student->name }}? This will also remove their exam marks.')">
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

            @if ($students->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    @endif
@endsection
