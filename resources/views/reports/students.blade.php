@extends('layouts.app')

@section('title', 'Student Averages Report')

@section('content')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Student Averages</h2>
            <p class="text-sm text-gray-500 mt-0.5">Average mark per student across all enrolled courses</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('reports.courses') }}"
                class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                View Course Report
            </a>
            <a href="{{ route('reports.students.export') }}"
                style="background-color: #15f166;"
                class="inline-flex items-center gap-2 px-2 py-2 bg-red-200 text-gray-700 border border-gray-300 text-sm font-medium rounded-lg hover:bg-red-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    {{-- Grade distribution summary --}}
    @if (!empty($gradeDistribution))
        <div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-3">Grade distribution (all exams)</p>
            <div class="flex items-end gap-2 flex-wrap">
                @foreach ($gradeDistribution as $grade => $data)
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-xs text-gray-500">{{ $data['percentage'] }}%</span>
                        <div
                            class="w-10 rounded-t text-center py-1 text-xs font-medium
                    {{ in_array($grade, ['A+', 'A', 'B+'])
                        ? 'bg-green-100 text-green-700'
                        : (in_array($grade, ['B', 'C+', 'C'])
                            ? 'bg-yellow-100 text-yellow-700'
                            : 'bg-red-100 text-red-700') }}">
                            {{ $grade }}
                        </div>
                        <span class="text-xs text-gray-400">{{ $data['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Table --}}
    @if ($rows->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <p class="text-gray-500 text-sm">No exam data available yet.</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-5 py-3 font-medium text-gray-500 w-10">No.</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Student</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Student ID</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Exams Taken</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Average Mark</th>
                        <th class="text-left px-5 py-3 font-medium text-gray-500">Grade</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($rows as $index => $row)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('students.show', $row->id) }}"
                                    class="font-medium text-gray-900 hover:text-indigo-600 transition">
                                    {{ $row->name }}
                                </a>
                                <div class="text-xs text-gray-400">{{ $row->email }}</div>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-xs text-gray-600">{{ $row->student_id }}</td>
                            <td class="px-5 py-3.5 text-gray-600">{{ $row->total_exams }}</td>
                            <td class="px-5 py-3.5">
                                {{-- Visual mark bar --}}
                                <div class="flex items-center gap-2">
                                    <span
                                        class="font-medium text-gray-900 w-10">{{ number_format($row->average_mark, 1) }}</span>
                                    <div class="flex-1 bg-gray-100 rounded-full h-1.5 max-w-24">
                                        <div class="h-1.5 rounded-full
                                    {{ $row->average_mark >= 80 ? 'bg-green-500' : ($row->average_mark >= 60 ? 'bg-yellow-400' : 'bg-red-400') }}"
                                            style="width: {{ min($row->average_mark, 100) }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span
                                    class="inline-block px-2 py-0.5 rounded text-xs font-medium
                            {{ $row->average_mark >= 80
                                ? 'bg-green-100 text-green-700'
                                : ($row->average_mark >= 60
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">
                                    {{ $row->grade }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                {{-- Footer summary row --}}
                <tfoot>
                    <tr class="bg-gray-50 border-t border-gray-200">
                        <td colspan="3" class="px-5 py-3 text-xs font-medium text-gray-500">
                            {{ $rows->count() }} students
                        </td>
                        <td class="px-5 py-3 text-xs font-medium text-gray-700">
                            {{ $rows->sum('total_exams') }} total
                        </td>
                        <td class="px-5 py-3 text-xs font-medium text-gray-700">
                            Overall avg: {{ number_format($rows->avg('average_mark'), 1) }}
                        </td>
                        <td class="px-5 py-3"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

@endsection
