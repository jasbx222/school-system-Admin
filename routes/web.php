<?php

use App\Exports\StudentInvoicesExport;
use App\Http\Controllers\ExportController;
use App\Livewire\Student ;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('invoices-export-excel/{id}', [ExportController::class, 'exportToExcel'])->name('invoices-export-excel');

Route::get('invoices-export-pdf/{id}', [ExportController::class, 'exportToPdf'])->name('invoices-export-pdf');
// Route::get('student/{student_id}', [Student::class])->name('student.show');
