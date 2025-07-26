<?php

namespace App\Http\Service\cost;

use App\Http\Controllers\Controller;
use App\Http\Resources\CostResource;
use App\Models\ClassroomSemester;
use App\Models\Semester;
use Illuminate\Http\Request;

class CostService
{
    /**
     * Display a listing of the classroom-semester assignments with relationships.
     */
    public function index()
    {
        $schoolId = auth()->user()->school_id;

    
    $classroomSemesters = ClassroomSemester::where('school_id', $schoolId)->get();
    
        return CostResource::collection($classroomSemesters);
    }

    /**
     * Store a new classroom-semester record.
     */
    public function store( $request)
    {
         $schoolId = auth()->user()->school_id;
        $data = $request->validate([
            'cost' => 'required|numeric',
            'class_room_id' => 'required|exists:class_rooms,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $data['school_id']=$schoolId;
        $record = ClassroomSemester::create($data);

        return response()->json([
            'data' => $record
        ], 201);
    }
    public function update( $request, $semester)
    {
         $schoolId = auth()->user()->school_id;
        $data = $request->validate([
            'cost' => 'required|numeric',
            'class_room_id' => 'required|exists:class_rooms,id',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $data['school_id']=$schoolId;
        $semester -> update($data);

        return response()->json([
            'data' => $semester
        ], 201);
    }

    public function delete(  $semester){
        $semester->delete();
        return response()->json([
            'message'=>'تم الحذف بنجاح'
        ],200);
    }


}
