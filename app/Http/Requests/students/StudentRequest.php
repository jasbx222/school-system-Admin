<?php

namespace App\Http\Requests\students;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
        'full_name' => ['required', 'string', 'max:255'],
        'mother_name' => ['required', 'string', 'max:255'],
        'profile_image_url' => ['nullable', 'string'],
        'file' => ['nullable', 'url'],
        'status' => ['required', 'in:مستمر,متخرج,منقطع'],
        'gender' => ['required', 'in:ذكر,أنثى'],
    'orphan' => ['required', 'in:نعم,لا'],
        'has_martyrs_relatives' => ['required', 'in:نعم,لا'],
        'last_school' => ['nullable', 'string'],
        'semester_id' => ['required', 'exists:semesters,id'],
        'class_room_id' => ['required', 'exists:class_rooms,id'],
        'class_section_id' => ['required', 'exists:class_sections,id'],
        'birth_day' => ['required', 'date'],
        'offer_id' => ['nullable', 'exists:offers,id'],
        'description' => ['nullable', 'string'],
    ];
}

}
