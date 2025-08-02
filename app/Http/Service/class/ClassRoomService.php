<?php

namespace App\Http\Service\class;

use App\Http\Resources\subjects\SubjectResource;
use App\Models\ClassRoom;
use App\Models\Subject;

class ClassRoomService {

   public function index()
{
    $schoolId = auth()->user()->school_id;

    // جلب الصفوف مع عدد الطلاب الذين ينتمون لنفس المدرسة ونفس الصف
    $classes = ClassRoom::where('school_id', $schoolId)
        ->withCount(['students as students_count' => function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        }])
        ->get();

    return response()->json([
        'classes' => $classes
    ], 200);
}
 

public function getAllStudentForClass($class){
    return response()->json([
        'students'=>$class->students
    ]);
}
 
public function subjects($class){
   
   return SubjectResource::collection($class->subjects);

}
}