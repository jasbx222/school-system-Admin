<?php
namespace App\Http\Requests\expenses;

use Illuminate\Foundation\Http\FormRequest;

class PaymentVouchersRequest extends FormRequest
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
            'vouchers_number' => 'required|string|unique:payment_vouchers,vouchers_number',
        ];
    }
}