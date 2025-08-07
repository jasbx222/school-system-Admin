<?php

namespace App\Http\Service\expenses\receipt;

use App\Http\Resources\receipts\ReceiptResource;
use App\Models\Account;
use App\Models\Receipt;
use Illuminate\Support\Facades\Auth;


class ReceiptService
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
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */

    public function store(array $data)
    {
        $schoolId = Auth::user()->school_id;
        $data['school_id'] = $schoolId;

        // إنشاء السند
        $receipt = Receipt::create($data);

        // تعديل رصيد الحساب المرتبط بالسند
        if (isset($data['account_id'])) {
            $account = Account::where('id', $data['account_id'])
                ->where('school_id', $schoolId)
                ->first();

            if ($account) {
                $account->balance += $data['amount'];
                $account->save();
            }
        }

        return new ReceiptResource($receipt);
    }
}
