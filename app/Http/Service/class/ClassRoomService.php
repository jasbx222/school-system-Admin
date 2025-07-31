<?php

namespace App\Http\Service\class;
use App\Models\ClassRoom;


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
 

public function store( $request){
 $schoolId = auth()->user()->school_id;
    $data =$request->validate([
        'title'=>'string'
    ]);
    $data['school_id']=$schoolId;
    $class =ClassRoom::create($data);
      return response()->json([
        'class' => $class
    ], 201);

}
}