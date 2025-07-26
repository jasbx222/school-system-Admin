<?php

namespace App\Http\Service\expenses;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoresRequest;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Box;
use App\Models\Expense;
use App\Models\CategoryExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExpenseService
{

    //box

    public function store_box( $request)
    {
        // تحقق من البيانات المطلوبة فقط
        $validatedData = $request->validate([
            'amount' => 'required|string',
        ]);

        // أضف school_id يدوياً بعد التحقق
        $validatedData['school_id'] = Auth::user()->school_id;

        // أنشئ السجل
        $box = Box::create($validatedData);

        return response()->json([
            'amount' => $box->amount,
        ], 201);
    }

    public function getAllBoxes()
    {
        $schoolId = auth()->user()->school_id;

        $box = Box::where('school_id', $schoolId)->get();
        return response()->json([
            'amount' => $box,
        ], 201);
    }

//Expenses 

    public function store( $request)
    {

        $data = $request->validated();
        $data['school_id'] = Auth::user()->school_id;
        $expenses = Expense::create($data);
        return response()->json([
            'expenses' => $expenses,
        ], 201);
    }


    public function index()
    {
        $schoolId = auth()->user()->school_id;

        $expenses = Expense::where('school_id', $schoolId)->get();
        return response()->json([
            'expenses' => $expenses,
        ], 201);
    }

    public function delete(  $expense){

        $expense->delete();
               return response()->json([
            'categores' => 'تم الحذف بنجاح',
        ], 200);

    }
    public function update( $request,  $expense){
  $data = $request->validated();
        $data['school_id'] = Auth::user()->school_id;
        $expense->update($data);
               return response()->json([
            'categores' => 'تم التعديل بنجاح',
        ], 200);

    }



    // categores 




    public function create_category( $request)
    {

        $data = $request->validate([
            'title' => 'string',
            'description' => 'string'
        ]);
        $data['school_id'] = Auth::user()->school_id;
        CategoryExpense::create($data);
        return response()->json([
            'message' => 'success',
        ], 201);
    }
    public function update_category( $request, $category)
    {

        $data = $request->validate([
            'title' => 'string',
            'description' => 'string'
        ]);
        $data['school_id'] = Auth::user()->school_id;
        $category->update($data);
        return response()->json([
            'message' => 'success',
        ], 201);
    }

    public function categores()
    {
        $schoolId = auth()->user()->school_id;

        $categores = CategoryExpense::where('school_id', $schoolId)->get();
        return response()->json([
            'categores' => $categores,
        ], 200);
    }

    public function delete_category ( $category){
        $category->delete();
              return response()->json([
            'categores' => 'تم الحذف بنجاح',
        ], 200);

    }
}
