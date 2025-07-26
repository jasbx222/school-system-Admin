<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\sections\SectionService;

class SectionController  extends Controller
{

    private $section;
    public function __construct(SectionService $sections)
    {
        return $this->section = $sections;
    }

    public function index()
    {
        return $this->section->index();
    }
}
