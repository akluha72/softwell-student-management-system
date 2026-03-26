<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamMarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'mark' => ['required', 'numeric', 'min:0', 'max:100'],
            'exam_date' => ['required', 'date'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.exists' => 'The selected student does not exist.',
            'course_id.exists' => 'The selected course does not exist.',
            'mark.min' => 'Mark cannot be less than 0.',
            'mark.max' => 'Mark cannot be more than 100.',
        ];
    }
}