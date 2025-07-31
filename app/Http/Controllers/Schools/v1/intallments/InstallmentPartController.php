<?php

namespace App\Http\Controllers\Schools\v1\intallments;

use App\Http\Controllers\Controller;
use App\Models\InstallmentPart;
use App\Http\Requests\StoreInstallmentPartRequest;
use App\Http\Requests\UpdateInstallmentPartRequest;
use App\Http\Service\intallments\InstallmentPartService;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallmentPartController extends Controller
{
    private $ins;
    public function __construct(InstallmentPartService $installment)
    {
        $this->ins=$installment;
    }
    public function store(Request $request, $installmentId)
    {
    
        return $this->ins->store($request,$installmentId);

    }

  
}
