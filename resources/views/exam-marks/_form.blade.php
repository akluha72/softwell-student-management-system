{{--
    Shared form partial for exam marks.
    Expects: $students, $courses, $examMark
    Optional: $selectedStudentId, $selectedCourseId (for pre-selection)
--}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

    {{-- Student --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Student <span class="text-red-500">*</span></label>
        <select name="student_id"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                       {{ $errors->has('student_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
            <option value="">— Select Student —</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}"
                    {{ (int) old('student_id', $examMark->student_id ?? ($selectedStudentId ?? '')) === $student->id ? 'selected' : '' }}>
                    {{ $student->name }} ({{ $student->student_id }})
                </option>
            @endforeach
        </select>
        @error('student_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Course --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Course <span class="text-red-500">*</span></label>
        <select name="course_id"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                       {{ $errors->has('course_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
            <option value="">— Select Course —</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                    {{ (int) old('course_id', $examMark->course_id ?? ($selectedCourseId ?? '')) === $course->id ? 'selected' : '' }}>
                    {{ $course->name }} ({{ $course->code }})
                </option>
            @endforeach
        </select>
        @error('course_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Mark --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Mark <span class="text-red-500">*</span>
            <span class="text-gray-400 font-normal">(0 – 100)</span>
        </label>
        <div class="relative">
            <input type="number" name="mark" value="{{ old('mark', $examMark->mark ?? '') }}" min="0"
                max="100" step="0.01"
                class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                          {{ $errors->has('mark') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                placeholder="e.g. 87.50" id="mark-input">
            {{-- Live grade preview --}}
            <span id="grade-preview"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-medium px-1.5 py-0.5 rounded hidden">
            </span>
        </div>
        @error('mark')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Exam Date --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Exam Date <span
                class="text-red-500">*</span></label>
        <input type="date" name="exam_date"
            value="{{ old('exam_date', isset($examMark->exam_date) ? $examMark->exam_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                      {{ $errors->has('exam_date') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
        @error('exam_date')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Remarks --}}
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
        <textarea name="remarks" rows="2"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
            placeholder="Optional notes about this result...">{{ old('remarks', $examMark->remarks ?? '') }}</textarea>
        @error('remarks')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>

{{-- Live grade preview script --}}
<script>
    const markInput = document.getElementById('mark-input');
    const gradePreview = document.getElementById('grade-preview');

    function getGrade(mark) {
        if (mark >= 90) return ['A+', 'bg-green-100 text-green-700'];
        if (mark >= 80) return ['A', 'bg-green-100 text-green-700'];
        if (mark >= 75) return ['B+', 'bg-green-100 text-green-700'];
        if (mark >= 70) return ['B', 'bg-yellow-100 text-yellow-700'];
        if (mark >= 65) return ['C+', 'bg-yellow-100 text-yellow-700'];
        if (mark >= 60) return ['C', 'bg-yellow-100 text-yellow-700'];
        if (mark >= 55) return ['D', 'bg-red-100 text-red-700'];
        return ['F', 'bg-red-100 text-red-700'];
    }

    function updateGradePreview() {
        const val = parseFloat(markInput.value);
        if (isNaN(val) || markInput.value === '') {
            gradePreview.classList.add('hidden');
            return;
        }
        const [grade, classes] = getGrade(val);
        gradePreview.textContent = grade;
        gradePreview.className =
            `absolute right-3 top-1/2 -translate-y-1/2 text-xs font-medium px-1.5 py-0.5 rounded ${classes}`;
    }

    markInput.addEventListener('input', updateGradePreview);
    updateGradePreview(); // run on page load for edit form
</script>
