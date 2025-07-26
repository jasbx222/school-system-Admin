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

   

   

    
}
