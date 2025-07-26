<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\StudentRequest;
use App\Http\Service\students\StudentService;
use App\Models\Attendance;
use App\Models\Student;

class StudentController extends Controller
{
    private $student;
    public function __construct(StudentService $student_service)
    {
        return $this->student = $student_service;
    }
    public function store(StudentRequest $request)
    {
        return $this->student->store($request);
    }
    public function update(StudentRequest $request, Student $student)
    {

        return $this->student->update($request, $student);
    }


    public function checkStudents(AttendanceRequest $request) {
      return $this->student->checkStudents($request);
    }

    public function delete($id)
    {
        $schoolId = auth()->user()->school_id;

        $student = Student::where('school_id', $schoolId)
            ->where('id', $id)
            ->first();

        if (!$student) {
            return response()->json([
                'message' => 'الطالب غير موجود أو لا يخص مدرستك.'
            ], 404);
        }
        $student->delete();

        return response()->json([
            'message' => 'تم الحذف بنجاح',
        ]);
    }

    public function getAllStatusCheck($studentId)
    {
        $student = Student::with('attendances')->find($studentId);

        $summary = $student->attendanceSummary()->get();

        $hadirCount = $summary->firstWhere('status', 'مجاز')->total ?? 0;
        $ghaibCount = $summary->firstWhere('status', 'غائب')->total ?? 0;

        return [
            'mojaz' => $hadirCount,
            'ghaib' => $ghaibCount,
        ];
    }
}
