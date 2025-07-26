<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomSemester extends Model
{
    use HasFactory;
    protected $table = 'classroom_semester';
    protected $fillable = [
        'cost',
        'class_room_id',
        'semester_id',
        'school_id',
    ];
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
