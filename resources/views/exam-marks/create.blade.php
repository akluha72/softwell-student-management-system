@extends('layouts.app')

@section('title', 'Add Exam Mark')

@section('content')
    <div class="max-w-2xl">

        <div class="mb-6">
            <a href="{{ route('exam-marks.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 transition">← Back to
                Exam Marks</a>
            <h2 class="text-xl font-semibold text-gray-900 mt-2">Add Exam Mark</h2>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('exam-marks.store') }}" method="POST">
                @csrf

                {{-- Pass redirect flag if pre-filled from a student page --}}
                @if ($selectedStudentId)
                    <input type="hidden" name="redirect_to_student" value="1">
                @endif

                @php $examMark = new \App\Models\ExamMark() @endphp
                @include('exam-marks._form')

                <div class="flex items-center justify-end gap-3 mt-6 pt-5 border-t border-gray-100">
                    <a href="{{ route('exam-marks.index') }}"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition">Cancel</a>
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                        Save Mark
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
