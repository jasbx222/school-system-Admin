<?php

namespace App\Filament\Widgets;

use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\Invoice;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $schoolId = auth()->user()->school_id;

        return [
            Stat::make('عدد الطلاب الكلي', Student::where('school_id', $schoolId)->count())
                ->color('danger')->icon('heroicon-o-user-group'),

            Stat::make('عدد الصفوف الكلي', ClassRoom::where('school_id', $schoolId)->count())
                ->color('primary')->icon('heroicon-o-bars-3-bottom-left'),

            Stat::make('عدد الشعب الكلي', ClassSection::where('school_id', $schoolId)->count())
                ->color('warning')->icon('heroicon-o-bars-3-center-left'),

            Stat::make('إجمالي الفواتير لهذا الشهر', $this->invoicesTotal($schoolId))
                ->color('success')->icon('heroicon-o-banknotes'),

            Stat::make('عدد الطلاب المستحقين الدفع', $this->duePaymentCount($schoolId))
                ->color('info')->icon('heroicon-o-banknotes'),
        ];
    }

    private function invoicesTotal($schoolId)
    {
        $currentMonth = now()->startOfMonth();

        return Invoice::whereBetween('created_at', [$currentMonth, now()])
            ->where('school_id', $schoolId)
            ->sum('value');
    }

    private function duePaymentCount($schoolId)
    {
        $students = Student::where('school_id', $schoolId)
            ->withSum('invoices', 'value')
            ->get();

        $count = 0;
        foreach ($students as $student) {
            if ($student->invoices_sum_value < $student->cost_of_semester_after_offer) {
                $count++;
            }
        }
        return $count;
    }
}
