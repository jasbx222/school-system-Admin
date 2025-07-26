<?php

namespace App\Livewire;

use App\Models\Student as ModelsStudent;
use Livewire\Component;

class Student extends Component
{
    public $student=[];
    public function mount(ModelsStudent $student_id)
    {
        $this->student = $student_id;
        
    }
    public function render()
    {
        return view('livewire.student');
    }
}
