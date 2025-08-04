<?php

namespace App\Http\Controllers\Schools\v1\students;

use App\Http\Controllers\Controller;
use App\Http\Requests\attendance\AttendanceRequest;
use App\Http\Requests\students\StudentRequest;
use App\Http\Service\students\StudentService;
use App\Models\Student;

class StudentController extends Controller
{
     //الطلاب

    private $student;
    public function __construct(StudentService $student_service)
    {
        return $this->student = $student_service;
    }


// get total student for the school 
    public function getAllStudentsForSchool()
    {
        
        return $this->student->getAllStudentsForSchool();
    }


    // get the student by his id  


    public function getStudentById($id)
    {
        
        return $this->student->getStudentById($id);
    }
      //create new student in the school the user login in with her


    public function store(StudentRequest $request)
    {
        return $this->student->store($request);
    }

    //update data the student
    public function update(StudentRequest $request, Student $student)
    {

        return $this->student->update($request, $student);
    }


        //this function check the student are ABSENT or PRESENT
    public function checkStudents(AttendanceRequest $request) {
      return $this->student->checkStudents($request);
    }


    //delete the student in the system
    public function delete($id)
    {
        //جلب الطلاب التابعين للمدرسة الربوطة مع المستخدم فقط 


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

    //get all status check  for student if he PRESENT or ABSENT

    //جلب حالات الغياب والاجازة لطالب معين





   public function getAllStatusCheck($studentId)
{
    $student = Student::with('attendances')->find($studentId);
    $summary = $student->attendanceSummary()->get();
    $mojazSummary = $summary->firstWhere('status', 'مجاز');
    $ghaibSummary = $summary->firstWhere('status', 'غائب');
    $mojazCount = $mojazSummary->total ?? 0;
    $ghaibCount = $ghaibSummary->total ?? 0;
    $resoneForMojaz = $mojazSummary->resone ?? 'لا يوجد سبب';
    $resoneForGhaib = $ghaibSummary->resone ?? 'لا يوجد سبب';
    return [
        'mojaz' => $mojazCount,
        'ghaib' => $ghaibCount,
        'resoneForMojaz' => $resoneForMojaz,
        'resoneForGhaib' => $resoneForGhaib,
    ];
}
}
