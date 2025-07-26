<?php

namespace App\Http\Service\sections;
use App\Models\ClassSection;
use Illuminate\Http\Request;

class SectionService{

      public function index()
{
    $schoolId = auth()->user()->school_id;

    // جلب الشعب مع عدد الطلاب الذين ينتمون لنفس المدرسة ونفس الصف
    $sections = ClassSection::where('school_id', $schoolId)
        ->withCount(['students as students_count' => function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        }])
        ->get();

    return response()->json([
        'sections' => $sections
    ], 200);
}
 public function store( $request){
 $schoolId = auth()->user()->school_id;
    $data =$request->validate([
        'title'=>'string',
        'class_room_id'=>'exists:class_rooms,id'
    ]);
    $data['school_id']=$schoolId;
    $section =ClassSection::create($data);
      return response()->json([
        'section' => $section
    ], 201);

}
}