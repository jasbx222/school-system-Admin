<?php

namespace App\Exports;

use App\Models\ExpensesReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpensesReportsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ExpensesReport::with('expense')->get()->map(function ($report) {
            return [
                'عنوان المصروف'      => $report->expense->title ?? '',
                'مبلغ المصروف'       => $report->expense->amount ?? '',
                'تاريخ المصروف'      => $report->expense->date ?? '',
                ' المدرسة'         => $report->expense->title ?? '',
                'وصف المصروف'        => $report->expense->description ?? '',
                'تصنيف المصروف'      => $report->expense->category_expense->title ?? '',
                'تاريخ التقرير'       => $report->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'عنوان المصروف',
            'مبلغ المصروف',
            'تاريخ المصروف',
            ' المدرسة',
            'وصف المصروف',
            'تصنيف المصروف',
            'تاريخ التقرير',
        ];
    }
}
