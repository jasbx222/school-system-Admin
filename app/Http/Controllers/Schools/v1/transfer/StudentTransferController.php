<?php

namespace App\Http\Controllers\Schools\v1\transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\studentTransfer\StudentTransferRequestStore;
use App\Http\Service\studentTransfer\StudentTransferService;

class StudentTransferController extends Controller
{
    private $studentTransferService;

    public function __construct(StudentTransferService $studentTransferService)
    {
        $this->studentTransferService = $studentTransferService;
    }

    //جلب كل عمليات النقل الطلاب

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return $this->studentTransferService->index();
    }
    //تخزين عملية نقل طالب
    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\studentTransfer\StudentTransferRequestStore  $request
     * @return \Illuminate\Http\JsonResponse
     *  */
    public function store(StudentTransferRequestStore $request)
    {
   
        return $this->studentTransferService->store($request->validated());
    }
    
  

}
