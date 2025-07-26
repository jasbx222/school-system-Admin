<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\class\ClassRoomService;
use Illuminate\Http\Request;

class ClassController  extends Controller
{

    private $class;
    public function __construct(ClassRoomService $classService)
    {

        return $this->class = $classService;
    }

    public function index()
    {
        return $this->class->index();
    }



    public function store(Request $request)
    {


        return $this->class->store($request);
    }
}
