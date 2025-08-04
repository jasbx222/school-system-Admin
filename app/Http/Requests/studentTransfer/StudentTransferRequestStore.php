<?php

namespace App\Http\Requests\studentTransfer;

use Illuminate\Foundation\Http\FormRequest;

class StudentTransferRequestStore extends FormRequest
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
     'student_id' => 'required|exists:students,id',
        'from_class_room_id' => 'required|exists:class_rooms,id',
          'transfer_date'=> 'nullable|date',
        'from_class_section_id' => 'required|exists:class_sections,id',
        'to_class_room_id' => 'required|exists:class_rooms,id',
        'to_class_section_id' => 'required|exists:class_sections,id',
        ];
    }
}
