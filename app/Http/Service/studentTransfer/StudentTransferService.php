<?php

namespace App\Http\Service\studentTransfer;

use App\Http\Resources\transfer\TransferResource;
use App\Models\Student;
use App\Models\StudentTransfer;
use Illuminate\Support\Facades\Auth;

class StudentTransferService
{
    public function index()
    {
        $studentTransfers = StudentTransfer::with('student', 'classRoom', 'classSection')->get();
        return TransferResource::collection($studentTransfers);
    }

   public function store(array $data)
{
    $data['school_id'] = Auth::user()->school_id;
    // تحديث بيانات الطالب
    $student = Student::findOrFail($data['student_id']);
    $student->update([
        'class_room_id' => $data['to_class_room_id'],
        'class_section_id' => $data['to_class_section_id'],
    ]);

    // إنشاء سجل النقل
    $studentTransfer = StudentTransfer::create($data);
    return response()->json([
        'message' => 'تم نقل الطالب بنجاح',
        'transfer' => $studentTransfer,
    ], 201);
}
}