<?php

namespace App\Http\Controllers\Schools\v1\section;

use App\Http\Controllers\Controller;
use App\Http\Service\sections\SectionService;

class SectionController  extends Controller
{
 //الشعب

    private $section;
    public function __construct(SectionService $sections)
    {
        return $this->section = $sections;
    }


    //just get all sections or the school

    
    public function index()
    {
        return $this->section->index();
    }
}
