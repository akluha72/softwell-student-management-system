{{--
    Shared form partial — used by both create.blade.php and edit.blade.php.
    Expects $course to be defined (new Course() for create, existing for edit).
--}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

    {{-- Course Name --}}
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Course Name <span
                class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $course->name) }}"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                      {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
            placeholder="e.g. Introduction to Programming">
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Course Code --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Course Code <span
                class="text-red-500">*</span></label>
        <input type="text" name="code" value="{{ old('code', $course->code) }}"
            class="w-full px-3 py-2 border rounded-lg text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500
                      {{ $errors->has('code') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
            placeholder="e.g. CS101">
        @error('code')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Credit Hours --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Credit Hours <span
                class="text-red-500">*</span></label>
        <select name="credit_hours"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                       {{ $errors->has('credit_hours') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
            @foreach (range(1, 6) as $credit)
                <option value="{{ $credit }}"
                    {{ (int) old('credit_hours', $course->credit_hours ?? 3) === $credit ? 'selected' : '' }}>
                    {{ $credit }} {{ $credit === 1 ? 'credit' : 'credits' }}
                </option>
            @endforeach
        </select>
        @error('credit_hours')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
            placeholder="Brief description of what this course covers...">{{ old('description', $course->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>
