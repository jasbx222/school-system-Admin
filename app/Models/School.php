<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function class_sections()
    {
        return $this->hasMany(ClassSection::class);
    }
    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }
    
  
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function getCountOfMaleStudentAttribute()
    {
        return $this->students->where('gender', Gender::MALE)->count();
    }
    public function getCountOfFemaleStudentAttribute()
    {
        return $this->students->where('gender', Gender::FEMALE)->count();
    }
  
    public function student_transfers(){
        return $this->hasMany(StudentTransfer::class);
    }
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
 
}
