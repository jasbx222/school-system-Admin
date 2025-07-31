<?php

namespace App\Http\Requests\categores;

use Illuminate\Foundation\Http\FormRequest;

class CategoresRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // غيّره حسب صلاحياتك إن احتجت
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|min:5|max:500',
       
        ];
    }
}
