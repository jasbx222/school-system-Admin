<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\semester\SemesterService;
use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\Offer;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    private $semester;
    public function __construct(SemesterService $semesters)
    {
        return $this->semester = $semesters;
    }
    public function index()
    {
        return $this->semester->index();
    }
}
