<?php

namespace App\Http\Controllers\Schools\v1\expenses\receipt;

use App\Http\Controllers\Controller;
use App\Http\Resources\receipts\ReceiptResource;
use App\Models\Account;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $schoolId = Auth::user()->school_id;
        // Assuming you have a Receipt model and it has a school_id field`
        $receipts = Receipt::with(
            'account'

        )->where('school_id', $schoolId)->get();
        return ReceiptResource::collection($receipts);
        // Logic to retrieve and return a list of receipts
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

public function store(Request $request)
{
    $data = $request->validate([
        'account_id' => 'required|exists:accounts,id',
        'amount' => 'required|numeric|min:0.01',
        'method' => 'nullable|string',
        'notes' => 'nullable|string',
        'receipt_number' => 'required|string|unique:receipts,receipt_number',
    ]);

    $schoolId = Auth::user()->school_id;

    // إنشاء قيد القبض
    $receipt = Receipt::create([
        'account_id' => $data['account_id'],
        'amount' => $data['amount'],
        'method' => $data['method'] ?? null,
        'notes' => $data['notes'] ?? null,
        'receipt_number' => $data['receipt_number'],
        'school_id' => $schoolId,
    ]);

    // تحديث رصيد الحساب
    $account = Account::find($data['account_id']);
    $account->balance += $data['amount'];
    $account->save();

    return new ReceiptResource($receipt);
}

}
