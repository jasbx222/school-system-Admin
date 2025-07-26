<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'value',
        'school_id',
        'note',
        'student_id',
    ];

    public function student()
{
    return $this->belongsTo(Student::class);
}

 public function school()
{
    return $this->belongsTo(School::class);
}

}
