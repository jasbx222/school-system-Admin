<?php

namespace App\Http\Controllers\Schools\v1\subjects;

use App\Http\Controllers\Controller;
use App\Http\Requests\subjects\SubjectsRequest;
use App\Models\Subject;


class SubjectController extends Controller
{

    protected $subjectService;

    public function __construct()
    {
        $this->subjectService = new \App\Http\Service\subjects\SubjectService();
    }

    public function index()
    {
        return $this->subjectService->index();
    }

    public function store(SubjectsRequest $request)
    {
        return $this->subjectService->store($request);
    }

    public function update(SubjectsRequest $request, Subject $subject)
    {
        return $this->subjectService->update($request, $subject);
    }

    public function destroy(Subject $subject)
    {
        return $this->subjectService->destroy($subject);
    }
}
