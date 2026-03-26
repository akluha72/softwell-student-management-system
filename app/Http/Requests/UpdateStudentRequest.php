<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('student')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', "unique:students,email,{$studentId}"],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'enrolled_at' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already registered to another student.',
            'student_id.unique' => 'This Student ID is already taken.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
        ];
    }
}