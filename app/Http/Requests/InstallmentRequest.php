<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallmentRequest extends FormRequest
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
        'title' => 'required|string',
            'amount' => 'required|numeric',
            'student_id' => 'required|exists:students,id',
            'status' => 'required|string',
            'is_split' => 'boolean',
            'parts' => 'nullable|array',
            'parts.*.amount' => 'required_with:parts|numeric',
            'parts.*.due_date' => 'required_with:parts|date',
        ];
    }
}
