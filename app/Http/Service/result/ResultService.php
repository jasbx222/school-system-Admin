<?php

namespace App\Http\Service\result;

use App\Http\Resources\result\ResultResource;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class ResultService
{
    //

    public function index()
    {
        $school_id = Auth::user()->school_id;

        $results = Result::where('school_id', $school_id)->get();

        return ResultResource::collection($results);
    }



    public function store($request)
    {

        $data = $request->validated();
        $data['school_id'] = Auth::user()->school_id;

        $results = Result::create($data);
       return response()->json(['message'=>'success'],200);
    }


    //

     public function update($request,$result)
    {

        $data = $request->validated();
        $data['school_id'] = Auth::user()->school_id;

        $result->update($data);
        return response()->json(['message'=>'success'],200);
    }


    
public function show($result){

    return new ResultResource($result);
}


//

public function delete($result){

    $result->delete();
    return response()->noContent();

}


}
