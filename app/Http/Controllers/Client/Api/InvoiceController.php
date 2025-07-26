<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Http\Service\invoice\InvoiceService;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
     private $invoice;

     public function __construct(InvoiceService $invoice_service)
     {
          return $this->invoice = $invoice_service;
     }
     public function index()
     {
          return $this->invoice->index();
     }

     //store th invo 

     public function store(InvoiceRequest $request)
     {
          return $this->invoice->store($request);
     }


     //uppdate the invo
     public function update(InvoiceRequest $request, Invoice $invoice)
     {
          return $this->invoice->update($request, $invoice);
     }
     //deleted invo
     public function delete(Invoice $invoice)
     {

          return $this->invoice->delete($invoice);
     }

     //show the invo by id
     public function show($invoice)
     {
          return $this->invoice->delete($invoice);
     }
}
