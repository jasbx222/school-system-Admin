<?php

namespace App\Http\Service\intallments;

use App\Http\Resources\installments\InstallmentResource;
use App\Models\Installment;
use App\Models\Offer;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class InstallmentService
{
   public function index()
{
    $installments = Installment::with('parts')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return response()->json([
        'data' => InstallmentResource::collection($installments->items()),
        'prev_page' => $installments->previousPageUrl(),
        'current_page' => $installments->currentPage(),
    
    ]);
}
//جلب مجمووع الخصومات كلها  للطلاب ككل 



public function getAllInsSum(){
    $paid= "paid";
       $installments = Installment::where('status',$paid)->get();

      
       return response()->json([
          'total'=>$installments->sum('amount')
       ]);
}




//جلب كل الاقساط الدفوعة
public function getAllInsPaid(){
    $paid= "paid";
       $installments = Installment::where('status',$paid)->get();

      
           
       return InstallmentResource::collection($installments);

}




//جلب كل الاقساط الغير مدفوعة
public function getAllInsPending(){
    $pending= "pending";
       $installments = Installment::where('status',$pending)->get();

      
       return InstallmentResource::collection($installments);

}






    //هنا راح نجيب الخصم وونقض من القسط على اساس قيمة الخصم للطالب 
 public function store($request)
{
    $validated = $request->validated();

    // جلب خصم الطالب إن وجد
    $offer = Offer::where('student_id', $validated['student_id'])->first();

    if ($offer) {
        $validated['amount'] -= $offer->value;
    }

    $validated['school_id'] = Auth::user()->school_id;

    $installment = Installment::create($validated);

    if (!empty($validated['parts'])) {
        $installment->parts()->createMany($validated['parts']);
    }

    return response()->json(['message' => 'تم اضافة القسط بنجاح'], 201);
}






    public function update($installment)
{
    $schoolId = Auth::user()->school_id;

    if ($installment->school_id !== $schoolId) {
        return response()->json(['message' => 'غير مصرح لك بتعديل هذا القسط'], 403);
    }
    $installment->status = $installment->status == "paid" ? "pending" : "paid";
    $installment->save();

    return response()->json([
        'message' => 'تم تحديث حالة القسط بنجاح',
    ]);
}


    public function show($id)
    {
        $installment = Installment::with('parts')->findOrFail($id);
        return new InstallmentResource($installment);
    }




    public function delete($installment)
    {
        $installment ->delete();

        return response()->json(['message'=>'تم الحذف بنجاح'],200);
    }


    public function getInstallmentsStudent($student)
    {

        return  InstallmentResource::collection($student->installments);
    }
}
