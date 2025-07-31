<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

 protected $casts = [
    'subjects' => 'json', 
];

    protected $table ='results';
    protected $fillable =[
              'student_id',
        'school_id',
        'subjects',
        'degree',
        'type_exam'
    ];

    public function student (){
        return $this ->belongsTo(Student::class);
    }

}
