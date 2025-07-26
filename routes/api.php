<?php

use App\Http\Controllers\Client\Api\ClassroomSemesterController;
use App\Http\Controllers\Client\Api\AuthController;
use App\Http\Controllers\Client\Api\ClassController;
use App\Http\Controllers\Client\Api\ExpenseController;
use App\Http\Controllers\Client\Api\HomeController;
use App\Http\Controllers\Client\Api\InvoiceController;
use App\Http\Controllers\Client\Api\OffresController;
use App\Http\Controllers\Client\Api\SectionController;
use App\Http\Controllers\Client\Api\SemesterController;
use App\Http\Controllers\Client\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//login
Route::get('/profile',[AuthController::class,'profile'])->middleware('auth:sanctum');
Route::post('/login',[AuthController::class,'login']);
Route::get('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

// home page 


Route::get('/students',[HomeController::class,'getAllStudentsForSchool'])->middleware('auth:sanctum');
Route::get('/students/{id}',[HomeController::class,'getStudentById'])->middleware('auth:sanctum');
Route::post('add/students/',[StudentController::class,'store'])->middleware('auth:sanctum');
Route::post('update/students/{student}',[StudentController::class,'update'])->middleware('auth:sanctum');

Route::delete('/delete/student/{id}',[StudentController::class,'delete'])->middleware('auth:sanctum');
Route::post('/attendances',[StudentController::class,'checkStudents'])->middleware('auth:sanctum');
Route::get('/attendanceRecords/{studentId}',[StudentController::class,'getAllStatusCheck'])->middleware('auth:sanctum');


//expenses 

Route::post('/box',[ExpenseController::class,'store_box'])->middleware('auth:sanctum');
Route::get('/box',[ExpenseController::class,'getAllBoxes'])->middleware('auth:sanctum');
Route::post('/expenses',[ExpenseController::class,'store'])->middleware('auth:sanctum');
Route::get('/expenses',[ExpenseController::class,'index'])->middleware('auth:sanctum');
Route::put('/expenses/{expense}',[ExpenseController::class,'update'])->middleware('auth:sanctum');
Route::delete('delete/expenses/{expense}',[ExpenseController::class,'delete'])->middleware('auth:sanctum');
Route::post('/categores',[ExpenseController::class,'create_category'])->middleware('auth:sanctum');
Route::get('/categores',[ExpenseController::class,'categores'])->middleware('auth:sanctum');
Route::put('/categores/{category}',[ExpenseController::class,'update_category'])->middleware('auth:sanctum');
Route::delete('delete/category/{category}',[ExpenseController::class,'delete_category'])->middleware('auth:sanctum');


//classes

Route::get('classes',[ClassController::class,'index'])->middleware('auth:sanctum');
Route::post('classes',[ClassController::class,'store'])->middleware('auth:sanctum');

//section

Route::get('sections',[SectionController::class,'index'])->middleware('auth:sanctum');
Route::post('sections',[SectionController::class,'store'])->middleware('auth:sanctum');



//class semester class
//التكاليف
Route::get('semesters/cost',[ClassroomSemesterController::class,'index'])->middleware('auth:sanctum');
Route::post('semesters/add',[ClassroomSemesterController::class,'store'])->middleware('auth:sanctum');
Route::put('semesters/update/{semester}',[ClassroomSemesterController::class,'update'])->middleware('auth:sanctum');
Route::delete('semesters/delete/{semester}',[ClassroomSemesterController::class,'delete'])->middleware('auth:sanctum');


//semester 
Route::get('semesters',[SemesterController::class,'index'])->middleware('auth:sanctum');
Route::post('semesters',[SemesterController::class,'store'])->middleware('auth:sanctum');



//offers 


Route::get('/sum/offer',[HomeController::class,'getAllOfferForSchool'])->middleware('auth:sanctum');
Route::get('/offers',[OffresController::class,'index'])->middleware('auth:sanctum');
Route::post('/offers',[OffresController::class,'store'])->middleware('auth:sanctum');
Route::put('/offers/{offer}',[OffresController::class,'update'])->middleware('auth:sanctum');
Route::delete('/offers/{offer}',[OffresController::class,'delete'])->middleware('auth:sanctum');


//Invoice 
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::post('/invoices', [InvoiceController::class, 'store']);
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show']);
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update']);
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'delete']);
});