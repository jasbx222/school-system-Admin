<?php
namespace App\Http\Requests\subjects;
use Illuminate\Foundation\Http\FormRequest;

class SubjectsRequest extends FormRequest

{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string',

            'class_room_id' => 'required|exists:class_rooms,id',

        ];
    }
}
