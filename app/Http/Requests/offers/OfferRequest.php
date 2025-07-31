<?php

namespace App\Http\Requests\offers;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{

 public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
       
   
        return [
            'note' => ['min:4', 'string','nullable'],
            'value' => ['required','integer'],
            'school_id' => [ 'string','exists:schools,id'],
            'student_id' => [ 'exists:students,id'],
        ];
    }

}