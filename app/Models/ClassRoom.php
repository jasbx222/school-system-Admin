<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'school_id'
    ];
    

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function students()
{
    return $this->hasMany(Student::class, 'class_room_id');
}
  public function student_transfers(){
        return $this->hasMany(StudentTransfer::class);
    }

    public function classSections()
    {
        return $this->hasMany(ClassSection::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
