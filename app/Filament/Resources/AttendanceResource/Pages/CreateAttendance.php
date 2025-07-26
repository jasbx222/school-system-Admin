<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Enums\AttendanceStatus;
use App\Filament\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Models\Student;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;

    public static ?string $title =  'إضافة تفقد';

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function handleRecordCreation(array $data): Model
    {
        $students = Student::where('class_section_id', $data['class_section_id'])->pluck('id')->toArray();
        $presentStudentIds = $data['student_ids'];
        foreach ($students as $id) {
            $attendance = new Attendance();
            $attendance->student_id = $id;
            if (in_array($id, $presentStudentIds)) {
                $attendance->status = AttendanceStatus::PRESENT;
            } else {
                $attendance->status = AttendanceStatus::ABSENT;
            }
            $attendance->save();
        }
        return Attendance::first();
    }
}
