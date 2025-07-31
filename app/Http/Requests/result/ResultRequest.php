<?php

namespace App\Http\Requests\result;

use Illuminate\Foundation\Http\FormRequest;

class ResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*.name' => ['required', 'string'],
            'subjects.*.degree' => ['required', 'numeric', 'min:0', 'max:100'],
              'type_exam'=>['string','in:day,month,year'],
        ];
    }
}
