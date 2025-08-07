<?php

namespace App\Http\Service\expenses\payment_vouchers;

use App\Models\Account;
use App\Models\PaymentVoucher;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;

class PaymentVoucherService
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $schoolId = Auth::user()->school_id;
        // Assuming you have a Receipt model and it has a school_id field`
        $receipts = PaymentVoucher::with(
            'account'
        )->where('school_id', $schoolId)->get();
        return response()->json($receipts);
        // Logic to retrieve and return a list of receipts
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(array $data)
    {
        $schoolId = Auth::user()->school_id;
        $data['school_id'] = $schoolId;
        $vouchers = PaymentVoucher::create($data);
  
        $account = Account::where('school_id', $schoolId)->first();
        $account->balance -= $data['amount'];
        $account->save();
        return response()->json([
            'message' => 'vouchers created successfully',
            'vouchers' => $vouchers,
        ], 201);
    }
}
