<?php

namespace App\Exports;

use App\Models\ClassroomSemester;
use App\Models\Invoice;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentInvoicesExport implements FromCollection, WithStyles
{
    protected $studentId;

    public function __construct($studentId)
    {
        $this->studentId = $studentId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $student = Student::find($this->studentId);
        $semesterCost = ClassroomSemester::where('class_room_id', $student->classRoom->id)
            ->where('semester_id', $student->semester->id)->first()->cost;
        if ($student->offer_id) {
            $semesterCost = $semesterCost - (($semesterCost * $student->offer->value) / 100);
        }

        $invoices = Invoice::where('student_id', $this->studentId)->get();
        $invoiceInfo[] = ['رقم الفاتورة', 'قيمة الفاتورة', 'تاريخ الفاتورة'];

        foreach ($invoices as $invoice) {
            $invoiceInfo[] = [
                'number' => $invoice->number,
                'value' => $invoice->value,
                'date' => $invoice->created_at,
            ];
        }

        return collect([
            ['InvoicesCount' => 'عدد الفواتير الكلي', 'InvoicesSum' => 'مجموع الفواتير', 'InvoicesRest' => 'مايجب تسديده'],
            ['Count' => (string)$invoices->count(), 'Sum' => (string)$invoices->sum('value'), 'Rest' => (string)$semesterCost - $invoices->sum('value')],
            [''],
        ])->merge($invoiceInfo);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A'    => ['font' => ['bold' => true, 'size' => 12, 'width' => 155]],
        ];
    }
}
