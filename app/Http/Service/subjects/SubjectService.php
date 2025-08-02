<?php





namespace App\Http\Service\subjects;

use App\Http\Resources\subjects\SubjectResource;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class SubjectService
{
    
    public const SUBJECT_CREATED = 'Subject created successfully';
    public const SUBJECT_DELETED = 'Subject deleted successfully';
    public function index()
    {

        $sub = Subject::with('classRoom')->where('school_id', Auth::user()->school_id)->get();
        return SubjectResource::collection($sub);
    }

    //

    public function store($request)
    {

        $data = $request->validated();
        $schoolID = Auth::user()->school_id;
        $data['school_id'] = $schoolID;

        Subject::create($data);
        return response()->json(['message' => 'success'], 200);
    }
    public function update($request, $subject)
    {
       
        $data = $request->validated();
        $schoolID = Auth::user()->school_id;
        $data['school_id'] = $schoolID;

        $subject->update($data);
        return response()->json(['message' => self::SUBJECT_CREATED], 2001);
    }

    public function destroy(Subject $subject)
    {
      
        $subject->delete();
        return response()->json(['message' => self::SUBJECT_DELETED], 200);
    }
}
