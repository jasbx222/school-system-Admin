<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // غيّره حسب صلاحياتك إن احتجت
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'category_expense_id' => 'required|exists:category_expenses,id',
            'status' => 'required|in:قبض,دفع',
        ];
    }
}
