<?php
namespace App\Http\Requests\expenses;
use Illuminate\Foundation\Http\FormRequest;

class ReceiptRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'method' => 'nullable|string',
            'notes' => 'nullable|string',
            'receipt_number' => 'required|string|unique:receipts,receipt_number',
        ];
    }
}