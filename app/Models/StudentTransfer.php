<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'student_id',
       'from_class_room_id',
       'school_id',
        'from_class_section_id',
        'to_class_room_id',
        'to_class_section_id',
    ];
    protected $table = 'student_transfers';
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
   
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);

    }
    public function classSection()
    {
        return $this->belongsTo(ClassSection::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
   
}
