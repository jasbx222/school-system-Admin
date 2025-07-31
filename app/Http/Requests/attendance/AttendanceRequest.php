<?php

namespace App\Http\Requests\attendance;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'status' => ['required', 'string'], 
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'رقم الطالب مطلوب',
            'student_id.integer' => 'رقم الطالب يجب أن يكون رقمًا صحيحًا',
            'student_id.exists' => 'الطالب غير موجود',

            'status.required' => 'الحالة مطلوبة',
    
        ];
    }
}
