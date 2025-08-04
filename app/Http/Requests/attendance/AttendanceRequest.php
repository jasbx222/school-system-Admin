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
            'resone'=> ['nullable', 'string', 'max:500','min:10'],
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
