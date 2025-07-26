<?php

namespace App\Http\Service\semester;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterService
{
    public function index()
    {
        $schoolId = auth()->user()->school_id;

        // جلب الفصول مع عدد الطلاب الذين ينتمون لنفس المدرسة ونفس الصف
        $semesters = Semester::where('school_id', $schoolId)
            ->withCount(['students as students_count' => function ($query) use ($schoolId) {
                $query->where('school_id', $schoolId);
            }])
            ->get();

        return response()->json([
            'semesters' => $semesters
        ], 200);
    }

    public function store( $request)
    {
        $schoolId = auth()->user()->school_id;
        $data = $request->validate([
            'title' => 'string',
            'from' => 'string',
            'to' => 'string'
        ]);
        $data['school_id'] = $schoolId;
        $semester = Semester::create($data);
        return response()->json([
            'semester' => $semester
        ], 201);
    }
}
