<?php
namespace App\Http\Service\invoice;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceService
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;
        $Invoice = Invoice::where('school_id', $schoolId)->get();

        return InvoiceResource::collection($Invoice);
    }

    //store th invo 

    public function store( $request)
    {
        $data = $request->validated();

        $data['school_id'] = Auth::user()->school_id;

        $Invoice = Invoice::create($data);
        return  new InvoiceResource($Invoice);
    }


    //uppdate the invo
    public function update( $request,  $invoice)
    {
        $data = $request->validated();
        $data['school_id'] = Auth::user()->school_id;
        $invoice->update($data);
        return new InvoiceResource($invoice);
    }
    //deleted invo
    public function delete( $invoice)
    {

        $invoice->delete();
        return response()->json('تم الحذف بنجاح');
    }

    //show the invo by id
    public function show( $invoice)
    {
        return  new InvoiceResource($invoice);
    }
}
