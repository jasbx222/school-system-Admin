<?php

use App\Http\Controllers\Schools\v1\auth\AuthController;
use App\Http\Controllers\Schools\v1\class\ClassController;
use App\Http\Controllers\Schools\v1\expenses\receipt\ReceiptController;
use App\Http\Controllers\Schools\v1\intallments\InstallmentController;
use App\Http\Controllers\Schools\v1\intallments\InstallmentPartController;
use App\Http\Controllers\Schools\v1\offers\OffresController;

use App\Http\Controllers\Schools\v1\result\ResultController;
use App\Http\Controllers\Schools\v1\section\SectionController;
use App\Http\Controllers\Schools\v1\semester\SemesterController;
use App\Http\Controllers\Schools\v1\students\StudentController;
use App\Http\Controllers\Schools\v1\subjects\SubjectController;
use App\Http\Controllers\Schools\v1\transfer\StudentTransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// this route version one for this project

Route::post('/login',[AuthController::class,'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::middleware(['auth:sanctum','check_expiry'])->group(function(){

//login
Route::get('/profile',[AuthController::class,'profile']);

Route::get('/logout',[AuthController::class,'logout']);


Route::get('/students',[StudentController::class,'getAllStudentsForSchool']);
Route::get('/students/{id}',[StudentController::class,'getStudentById']);
Route::post('add/students/',[StudentController::class,'store']);
Route::post('update/students/{student}',[StudentController::class,'update']);
Route::delete('/delete/student/{id}',[StudentController::class,'delete']);
Route::post('/attendances',[StudentController::class,'checkStudents']);
Route::get('/attendanceRecords/{studentId}',[StudentController::class,'getAllStatusCheck']);


//expenses 



//classes


// get all classes for school 
Route::get('classes',[ClassController::class,'index']);

//جلب الواد لكلاس معين
Route::get('class/{class}/subjects',[ClassController::class,'subjects']);

// get all students for class by class id

Route::get('students/{class}/class',[ClassController::class,'getAllStudentForClass']);




//section

Route::get('sections',[SectionController::class,'index']);



//semester 
Route::get('semesters',[SemesterController::class,'index']);


//offers 


Route::get('/sum/offer',[OffresController::class,'getAllOfferForSchool']);
Route::get('/offers',[OffresController::class,'index']);
Route::post('/offers',[OffresController::class,'store']);
Route::put('/offers/{offer}',[OffresController::class,'update']);
Route::delete('/offers/{offer}',[OffresController::class,'delete']);




Route::apiResource('installments', InstallmentController::class);
//اقساط طالب معين
Route::get('installments/{student}/student', [InstallmentController::class,'getInstallmentsStudent']);
//create parts of installments
Route::post('installments/{installment}/parts', [InstallmentPartController::class, 'store']);

//مجموع كل الاقساط
Route::get('/sum/installments/', [InstallmentController::class, 'getAllInsSum']);

//جلب الاقساط الدفوعة

Route::get('/paid/installments', [InstallmentController::class, 'getAllInsPaid']);

//جلب الاقساط الغير الدفوعة

Route::get('/pending/installments', [InstallmentController::class, 'getAllInsPending']);




//results route 

Route::apiResource('results',ResultController::class)->names([
    'index'=>'index.index',
    'show'=>'results.show'
]);


//subjects


Route::apiResource('subjects',SubjectController::class);


//student transfer
Route::apiResource('student-transfers', StudentTransferController::class);

//accounts
Route::get('accounts', [\App\Http\Controllers\Schools\v1\account\AccountController::class, 'index']);

//receipts
Route::apiResource('receipts', ReceiptController::class);


});
