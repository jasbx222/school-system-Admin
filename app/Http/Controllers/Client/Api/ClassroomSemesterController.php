<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\cost\CostService;
use App\Models\ClassroomSemester;
use App\Models\Semester;
use Illuminate\Http\Request;

class ClassroomSemesterController extends Controller
{
    private $cost;

    public function __construct(CostService $cost_service)
    {
        return $this->cost = $cost_service;
    }
    /**
     * Display a listing of the classroom-semester assignments with relationships.
     */
    public function index()
    {
        return $this->cost->index();
    }

    /**
     * Store a new classroom-semester record.
     */
    public function store(Request $request)
    {

        return $this->cost->store($request);
    }
    public function update(Request $request, ClassroomSemester $semester)
    {

        return $this->cost->update($request, $semester);
    }

    public function delete(ClassroomSemester $semester)
    {
        return $this->cost->delete($semester);
    }
}
