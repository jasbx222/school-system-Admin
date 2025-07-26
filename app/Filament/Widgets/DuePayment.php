<?php

namespace App\Filament\Widgets;

use App\Models\ClassroomSemester;
use App\Models\Student;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class DuePayment extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public static ?string $heading = 'الطلاب المستحقين الدفع';

    protected function getTableQuery(): Builder
    {
        $students = Student::withSum('invoices', 'value')
            ->with(['semester', 'classSection'])
            ->get();

        $filteredStudents = $students->filter(function ($student) {
            return $student->invoices_sum_value < $student->cost_of_semester_after_offer;
        });

        $filteredStudentIds = $filteredStudents->pluck('id');
        $query = Student::whereIn('id', $filteredStudentIds);
        return $query;
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('full_name')
                ->label('اسم الطالب'),
            Tables\Columns\TextColumn::make('sum_of_invoices')
                ->label('المبلغ الذي تم تسديده'),
            Tables\Columns\TextColumn::make('rest_of_invoices')
                ->label('المبلغ المستحق دفعه'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns($this->getTableColumns())
            ->query($this->getTableQuery())
            ->emptyStateHeading('لا توجد بيانات');
    }
}
