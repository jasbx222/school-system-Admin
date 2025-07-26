<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // غيّرها حسب صلاحياتك
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'number'     => ['required', 'string', 'max:255', 'unique:invoices,number'],
            'value'      => ['required', 'numeric', 'min:0'],
        ];
    }
}
