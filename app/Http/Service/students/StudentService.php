<?php

namespace App\Http\Service\students;


use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\StudentRequest;
use App\Models\Attendance;
use App\Models\Student;

class StudentService{
    public function store( $request)
    {
        $data = $request->validated();

        // إضافة school_id من المستخدم الحالي
        $data['school_id'] = auth()->user()->school_id;
        Student::create($data);

        return response()->json([
            'message' => 'تم حفظ بيانات الطالب بنجاح.',
        ], 201);
    }
    public function update( $request , $student)
    {
        $data = $request->validated();

        // إضافة school_id من المستخدم الحالي
        $data['school_id'] = auth()->user()->school_id;
        $student ->update($data);

        return response()->json([
            'message' => 'تم تحديث بيانات الطالب بنجاح.',
        ], 201);
    }


    public function checkStudents( $request)
    {
        $data = $request->validated();
        $data['school_id'] = auth()->user()->school_id;
        $attendance = Attendance::create($data);

        return response()->json([
            'message' => 'تم تسجيل الحضور بنجاح',
            'data' => $attendance
        ], 201);
    }

   

   // get total student for the school 
    public function getAllStudentsForSchool()
    {
        $schoolId = auth()->user()->school_id;
        $students = Student::where('school_id', $schoolId)->get();

    return response()->json([
                'students' => $students
            ], 200);
    }


    // get the student by his id  


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
    
}
