<?php

namespace App\Http\Service\intallments;

use App\Http\Controllers\Controller;
use App\Models\InstallmentPart;
use App\Http\Requests\StoreInstallmentPartRequest;
use App\Http\Requests\UpdateInstallmentPartRequest;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallmentPartService
{
    public function store( $request, $installmentId)
    {
        $installment = Installment::findOrFail($installmentId);

        $validated = $request->validate([
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);
  
        $part = $installment->parts()->create($validated);

        return response()->json($part, 201);
    }
}
