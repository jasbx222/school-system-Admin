<?php

namespace App\Http\Controllers;

use App\Exports\StudentInvoicesExport;
use App\Models\ClassroomSemester;
use App\Models\Invoice;
use App\Models\Student;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportToExcel($id)
    {
        $student = Student::findOrFail($id);
        return Excel::download(
            new StudentInvoicesExport($id),
            date('Y-m-d') . '-' .  $student->full_name . '-invoices-export.xlsx'
        );
    }

    public function exportToPdf($id)
    {
        $student = Student::findOrFail($id);
        $invoices = Invoice::where('student_id', $id)->get();

        $semesterCost = ClassroomSemester::where('class_room_id', $student->classRoom->id)
            ->where('semester_id', $student->semester->id)->first()->cost;
        if ($student->offer_id) {
            $semesterCost = $semesterCost - (($semesterCost * $student->offer->value) / 100);
        }
        $reportHtml = view('filament.resources.student-resource.pages.student-invoices-pdf', [
            'student' => $student->full_name,
            'invoices' => $invoices,
            'cost_of_semester_after_offer' => $semesterCost,
            'sum_of_invoices' => $invoices->sum('value'),
            'rest_of_invoices' => $semesterCost - $invoices->sum('value'),
        ])->render();

        $arabic = new Arabic();
        $p = $arabic->arIdentify($reportHtml);

        for ($i = count($p) - 1; $i >= 0; $i -= 2) {
            $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i - 1], $p[$i] - $p[$i - 1]));
            $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i - 1], $p[$i] - $p[$i - 1]);
        }

        $pdf = Pdf::loadHTML($reportHtml);
        return $pdf->download(date('Y-m-d') . '-' .  $student->full_name . '.pdf');
    }
}
