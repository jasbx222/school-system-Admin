<?php

namespace App\Http\Service\students;

use App\Models\Attendance;
use App\Models\Student;

class StudentService
{
    public function store($request)
    {
        $data = $request->validated();

        // رفع الصورة إذا موجودة
        if ($request->hasFile('profile_image_url')) {
            $imagePath = $request->file('profile_image_url')->store('students', 'public');
            $data['profile_image_url'] = 'storage/' . $imagePath;
        }

        // إضافة school_id
        $data['school_id'] = auth()->user()->school_id;

        Student::create($data);

        return response()->json([
            'message' => 'تم حفظ بيانات الطالب بنجاح.',
        ], 201);
    }

    public function update($request, $student)
    {
        $data = $request->validated();

        // رفع صورة جديدة إذا تم رفعها
        if ($request->hasFile('profile_image_url')) {
            $imagePath = $request->file('profile_image_url')->store('students', 'public');
            $data['profile_image_url'] = 'storage/' . $imagePath;
        }

        // إضافة school_id
        $data['school_id'] = auth()->user()->school_id;

        $student->update($data);

        return response()->json([
            'message' => 'تم تحديث بيانات الطالب بنجاح.',
        ], 201);
    }


    public function checkStudents($request)
    {
        $data = $request->validated();
        $data['school_id'] = auth()->user()->school_id;
        $attendance = Attendance::create($data);

        return response()->json([
            'message' => 'تم تسجيل الحضور بنجاح',
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

        //هاي اكدر اخليها بريسورس مختصر اكثر لكن ضفتها هيك هاي تساعد لضهور الصور لبروفايل الطالب 
        $student->profile_image_url = $student->profile_image_url
            ? asset($student->profile_image_url)
            : null;

        return response()->json([
            'student' => $student,
        ]);
    }
}
