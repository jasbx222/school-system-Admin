<?php

namespace App\Http\Controllers\Schools\v1\expenses\receipt;

use App\Http\Controllers\Controller;
use App\Http\Requests\expenses\ReceiptRequest;
use App\Http\Service\expenses\receipt\ReceiptService;

class ReceiptController extends Controller
{

    protected $receiptService;

    public function __construct( ReceiptService $receiptServiceClass )
    {
        $this->receiptService = $receiptServiceClass;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->receiptService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\expenses\ReceiptRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptRequest $request)
    {
        return $this->receiptService->store($request->validated());
    }

}
