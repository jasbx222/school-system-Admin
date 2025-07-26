<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'class_room_id',
        'school_id'
    ];
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
