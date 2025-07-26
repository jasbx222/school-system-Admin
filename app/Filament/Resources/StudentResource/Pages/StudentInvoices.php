<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\Student;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Database\Eloquent\Model;

class StudentInvoices extends Page
{
    use InteractsWithRecord;

    protected static string $resource = StudentResource::class;

    public static ?string $title = ' كشف حساب الطالب';

    protected static string $view = 'filament.resources.student-resource.pages.student-invoices';

    public $studentRecord;

    public function mount(int | string $record): void
    {
        $this->studentRecord = Student::findOrFail($record);
    }

    public function getRecord(): Model
    {
        return $this->studentRecord;
    }
}
