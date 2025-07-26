<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Student;

class HomeController extends Controller
{
    public function getAllStudentsForSchool()
    {
        $schoolId = auth()->user()->school_id;
        $students = Student::where('school_id', $schoolId)->get();

        // حساب عدد الطلاب
        $totalStudents = $students->count();

        return response()->json([
            'students' => $students,
            'total' => $totalStudents,
        ]);
    }
    public function getStudentById($id)
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

        return response()->json([
            'student' => $student,
        ]);
    }

    public function getAllOfferForSchool()
    {
        $schoolId = auth()->user()->school_id;

        $offers = Offer::where('school_id', $schoolId)->get();
        $total = $offers->sum('value');

        return response()->json([
            'total' => $total,
        ]);
    }
}
