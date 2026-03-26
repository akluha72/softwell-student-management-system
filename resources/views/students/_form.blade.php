{{--
    Shared form partial — used by both create.blade.php and edit.blade.php.
    Expects $student to be defined (new Student() for create, existing for edit).
--}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

    {{-- Name --}}
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $student->name) }}"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                      {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
            placeholder="e.g. Ahmad Fariz bin Zulkifli">
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" value="{{ old('email', $student->email) }}"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                      {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
            placeholder="student@example.edu.my">
        @error('email')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Student ID --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Student ID <span
                class="text-red-500">*</span></label>
        <input type="text" name="student_id" value="{{ old('student_id', $student->student_id) }}"
            class="w-full px-3 py-2 border rounded-lg text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500
                      {{ $errors->has('student_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
            placeholder="e.g. STU-2024-001">
        @error('student_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Phone --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
            placeholder="e.g. 012-3456 7890">
        @error('phone')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Gender --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
        <select name="gender"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">— Select —</option>
            @foreach (['male' => 'Male', 'female' => 'Female'] as $value => $label)
                <option value="{{ $value }}"
                    {{ old('gender', $student->gender) === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('gender')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Date of Birth --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
        <input type="date" name="date_of_birth"
            value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        @error('date_of_birth')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Enrolled At --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Enrolled Date <span
                class="text-red-500">*</span></label>
        <input type="date" name="enrolled_at"
            value="{{ old('enrolled_at', $student->enrolled_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
            class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500
                      {{ $errors->has('enrolled_at') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
        @error('enrolled_at')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>
