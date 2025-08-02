<?php

namespace App\Http\Controllers\Schools\v1\semester;

use App\Http\Controllers\Controller;
use App\Http\Service\semester\SemesterService;

class SemesterController extends Controller
{
     //الفصول الدراسية

    private $semester;
    public function __construct(SemesterService $semesters)
    {
        return $this->semester = $semesters;
    }


     //just get all semester or the school
 
    public function index()
    {
        return $this->semester->index();
    }
}
