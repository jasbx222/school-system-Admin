<?php

namespace App\Http\Controllers\Schools\v1\expenses\payment_vouchers;

use App\Http\Controllers\Controller;
use App\Http\Requests\expenses\PaymentVouchersRequest;
use App\Http\Service\expenses\payment_vouchers\PaymentVoucherService;
use App\Models\Account;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentVoucherController extends Controller
{
    protected $paymentVoucherService;

    public function __construct()
    {
        $this->paymentVoucherService = new PaymentVoucherService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->paymentVoucherService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\expenses\PaymentVouchersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentVouchersRequest $request)
    {
        return $this->paymentVoucherService->store($request->validated());
    }
}
