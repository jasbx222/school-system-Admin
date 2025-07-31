<?php

namespace App\Http\Controllers\Schools\v1\class;

use App\Http\Controllers\Controller;
use App\Http\Service\class\ClassRoomService;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassController  extends Controller
{

    private $class;
    public function __construct(ClassRoomService $classService)
    {

        return $this->class = $classService;
    }

    // get all classes for school id the user has log in 
    public function index()
    {
        return $this->class->index();
    }
    // get all students for class id 
    public function getAllStudentForClass(ClassRoom $class)
    {
        return $this->class->getAllStudentForClass($class);
    }


// this function we dont used right now 
    public function store(Request $request)
    {


        return $this->class->store($request);
    }
}
